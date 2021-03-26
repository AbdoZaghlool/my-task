<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthUserController extends Controller
{
    /**
     * register user data to storage
     *
     * @param Request $request
     * @return UserResource
     */
    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|max:255',
            'email'                 => 'sometimes|email|unique:users',
            'phone_number'          => 'required|unique:users|digits:11',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'image'                 => 'sometimes|mimes:jpeg,bmp,png,jpg|max:3000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }

        $user = User::create([
            'name'              => $request->name,
            'phone_number'      => $request->phone_number,
            'password'          => Hash::make($request->password),
            'email'             => $request->email,
            'image'             => $request->image == null ? null : UploadImage($request->file('image'), 'user', '/uploads/users'),
        ]);
        Auth::guard('api')->check(['phone_number' => $request->phone_number, 'password' => $request->password]);
        $token = generateApiToken($user->id, 15);
        $user->update(['api_token' => $token]);
        $savedUser = new UserResource($user);
        return $user ? ApiController::respondWithSuccess($savedUser) : ApiController::respondWithServerErrorArray();
    }

    /**
     * log user into application.
     *
     * @param Request $request
     * @return UserResource obj
     */
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }

        if ($check = Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();
            
            $updated = $user->update(['api_token' => generateApiToken($user->id, 15)]);

            return $updated
            ? ApiController::respondWithSuccess(new UserResource($user))
            : ApiController::respondWithServerErrorArray();
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                $phone = ['key' => 'email', 'value' => 'البريد الالكتروني غير صحيح'];
                return ApiController::respondWithErrorClient(array($phone));
            } else {
                $password = ['key' => 'password', 'value' => ' الرقم السري غير صحيح'];
                return ApiController::respondWithErrorClient(array($password));
            }
        }
    }

    /**
     * search for user phone and send verification code if exists
     *
     * @param Request $request
     * @return void
     */
    public function forgetPassword(Request $request)
    {
        $rules = [
            'phone_number'  => 'required|numeric|exists:users,phone_number',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }

        $user = App\User::where('phone_number', $request->phone_number)->first();

        $code = mt_rand(1000, 9999);
        $this->sendSMS($request, $code);
        
        $updated = $user->update([
                'verification_code' => $code,
        ]);
        $success = [
            'key' => 'message',
            'value' => "تم ارسال الكود بنجاح",
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }

    /**
     * verify the code to change password
     *
     * @param Request $request
     * @return void
     */
    public function confirmResetCode(Request $request)
    {
        $rules = [
            'phone_number' => 'required|exists:users,phone_number',
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }
        $user = App\User::where('phone_number', $request->phone_number)->where('verification_code', $request->code)->first();
        if ($user) {
            $updated = $user->update([
                'verification_code' => null,
            ]);
            $success = [
                'key' => 'message',
                'value' => "الكود صحيح",
            ];
            return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
        } else {
            $errorsLogin = [
                'key' => 'user',
                'value' => trans('messages.error_code'),
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }
    }

    /**
     * reset the password to a new one
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {
        $rules = [
            'phone_number'          => 'required|numeric',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }
        $user = App\User::where('phone_number', $request->phone_number)->first();
        if ($user) {
            $updated = $user->update(['password' => Hash::make($request->password)]);
        } else {
            $errorsLogin = [
                'key' => 'message',
                'value' => trans('messages.Wrong_phone'),
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }
        return $updated
        ? ApiController::respondWithSuccess(trans('messages.Password_reset_successfully'))
        : ApiController::respondWithServerErrorObject();
    }

    /**
     * change user password
     *
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }
        $error_old_password = [
            'key' => 'message',
            'value' => trans('messages.error_old_password'),
        ];
        if (!(Hash::check($request->current_password, auth('api')->user()->password))) {
            return ApiController::respondWithErrorNOTFoundObject(array($error_old_password));
        }

        $updated = auth('api')->user()->update(['password' => Hash::make($request->new_password)]);
        $success_password = [
            'key' => 'message',
            'value' => trans('messages.Password_reset_successfully'),
        ];
        return $updated
        ? ApiController::respondWithSuccess($success_password)
        : ApiController::respondWithServerErrorObject();
    }

    /**
     * change user phone_number
     *
     * @param Request $request
     * @return void
     */
    public function change_phone_number(Request $request)
    {
        $rules = [
            'phone_number'  => 'required|unique:users|starts_with:05|digits:10',
            'app_signature' => 'sometimes',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }

        $code = mt_rand(1000, 9999);
        $this->sendSMS($request, $code);
        $updated = App\User::where('id', auth('api')->user()->id)->update([
            'verification_code' => $code,
        ]);
        $success = [
            'key' => 'message',
            'value' => trans('messages.success_send_code'),
        ];
        return $updated
        ? ApiController::respondWithSuccess($success)
        : ApiController::respondWithServerErrorObject();
    }

    /**
     * verify code sent to new phone number before save it
     *
     * @param Request $request
     * @return void
     */
    public function check_code_changeNumber(Request $request)
    {
        $rules = [
            'code' => 'required',
            'phone_number' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        }

        $user = App\User::where('id', auth('api')->user()->id)->where('verification_code', $request->code)->first();
        if ($user) {
            $updated = $user->update([
                'verification_code' => null,
                'phone_number' => $request->phone_number,
            ]);
            $success = [
                'key' => 'message',
                'value' => "تم تغيير رقم الهاتف",
            ];
            return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
        } else {
            $errorsLogin = [
                'key' => 'message',
                'value' => trans('messages.error_code'),
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }
    }

    /**
     * log user out from our application
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $users = App\User::where('id', auth('api')->user()->id)->first()->update([
                'api_token' => null,
            ]);
        return $users
        ? ApiController::respondWithSuccess([])
        : ApiController::respondWithServerErrorArray();
    }


    /**
     * prepare data to send messages using external api
     *
     * @param [type] $jsonObj
     * @return void
     */
    public function sendSMS($request, $code)
    {
        $result = substr($request->phone_number, 1);
        $phone = '00966' . $result;

        $jsonObj = array(
            'mobile'          => '2222',
            'password'        => '',
            'sender'          => '',
            'numbers'         => $phone,
            'msg'             => '<#> كود التأكيد الخاص بك في تطبيقي هو :'
            . $code . ' لا تقم بمشاركة هذا الكود مع اي شخص ' . $request->app_signature??5526,
            'msgId'           => rand(1, 99999),
            'timeSend'        => '0',
            'dateSend'        => '0',
            'deleteKey'       => '55348',
            'lang'            => '3',
            'applicationType' => 68,
        );

        $contextOptions['http'] = array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($jsonObj), 'max_redirects' => 0, 'protocol_version' => 1.0, 'timeout' => 10, 'ignore_errors' => true);
        $contextResouce = stream_context_create($contextOptions);
        $url = "http://www.alfa-cell.com/api/msgSend.php";
        $arrayResult = file($url, FILE_IGNORE_NEW_LINES, $contextResouce);
        $result = $arrayResult[0];
        return $result;
    }
}