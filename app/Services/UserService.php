<?php

namespace App\Services;

use App\Mail\ActivateUserMail;
use App\Models\Classroom;
use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use App\Trait\UploadFileTrait;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{

    use UploadFileTrait;
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function paginate(array $params)
    {
        // Nếu có limit và > 0 thì dùng, ngược lại lấy mặc định từ config
        $limit = (!empty($params['limit']) && (int)$params['limit'] > 0)
            ? (int)$params['limit']
            : config('repository.pagination.limit', 15);

        // Giới hạn max
        $params['limit'] = $limit > 100 ? 100 : $limit;
        return $this->userRepo->with('classes')->paginate($params['limit']);
    }

    public function create(array $payload)
    {
        // Bước 1: Kiểm tra điều kiện đầu vào trước
        if ($payload['password'] !== $payload['re_password']) {
            // Nếu không thỏa mãn, không làm gì cả và trả về false
            return false;
        }

        DB::beginTransaction();

        try {
            // Bước 2: Chuẩn bị dữ liệu cho việc tạo user
            // Gán trực tiếp khóa ngoại cho quan hệ belongsTo (một-nhiều)
            // Bỏ re_password vì không cần lưu vào DB
            unset($payload['re_password']);

            // Mã hóa mật khẩu và token
            $payload['password'] = Hash::make($payload['password']);
            $payload['activation_token'] = Hash::make($payload['activation_token']); // Cân nhắc lại việc hash token này

            // Upload file và lấy đường dẫn
            if (isset($payload['avatar']) && !empty($payload['avatar'])) {
                $payload['avatar'] =  $this->uploadFIle($payload['avatar'], 'uploads');
            }

            $user = $this->userRepo->create($payload);


            $user->classes()->attach($payload['class_id']);

            // Bước 4: Gửi mail kích hoạt
            Mail::to($user->email)->send(new ActivateUserMail($user));

            // Nếu mọi thứ thành công, xác nhận giao dịch
            DB::commit();

            return true;
        } catch (Exception $e) {
            // Nếu có bất kỳ lỗi nào xảy ra, hủy bỏ tất cả thay đổi
            DB::rollBack();
            // Ghi lại lỗi để debug, không nên echo và exit()
            echo $e->getMessage();
            exit();
            Log::error('Lỗi khi tạo user: ' . $e->getMessage());

            return false;
        }
    }


    public function update($id, $request)
    {
        DB::beginTransaction();

        try {

            $user = $this->userRepo->find($id);
            if ($user) {
                $payload = $request->except(['_token']);
                $user->classes()->sync($payload['class_id']);
                $user->subjects()->sync($payload['subject_id']);
                  $this->userRepo->update($payload, $id);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->userRepo->find($id);
            if ($user) {
                $user->classes()->detach();
            }

            $this->userRepo->delete($id);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            exit();
            return false;
        }
    }
}
