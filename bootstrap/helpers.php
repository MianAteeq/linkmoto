<?php

use App\Models\BankAccount;
use App\Models\User;
use Modules\Vender\Entities\VenderAddress;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Clue\StreamFilter\fun;

function getEndDate($user)
{
    $sub = $user->subscriptions()->first()['name'] ?? '';
    if ($user->subscribed($sub)) {

        return "Active";
    } else {
        return "InActive";
    }
}
function getHeaderForCompany($no)
{

    if ($no === 1) {

        return "Registered company name only";
    } elseif ($no === 2) {
        return "Registered company name & trading name";
    } else {
        return "Trading name only";
    }
}
function getHeaderForSoleTrader($no)
{

    if ($no === 1) {

        return "(Registered sole trader name with HMRC";
    } elseif ($no === 2) {
        return "Registered sole trader name & trading name";
    } else {
        return "Trading name only";
    }
}


function getPermission()
{
    if (auth()->user()->vender_id == 0) {
        return  $permissions = Permission::where('group_type', 'BUSINESS')->pluck('name');
    } else {

        if (isset(auth()->user()['business_app']['group'])) {

            return $permissions = collect(auth()->user()['business_app']['group']['permissions'])->pluck('name');
        } else {
            return [];
        }
        //    return $permissions=Permission::where('group_type','BUSINESS')->pluck('name');
    }
}


function createPermissionServiceProvider()
{

    $roles = ["Manager", "Customer Services", "Operations", "Technician"];

    foreach ($roles as $key => $role) {
        $role = Role::create([
            'name' => $role . "SVP_" . auth()->user()->id,
            'group_type' => 'System Default',
            'type' => 'APP',
            'vender_id' => auth()->user()->id
        ]);

        $permissions = Permission::where('group_type', 'APP')->get()->pluck('id');

        $role->syncPermissions($permissions);
    }

    return 1;
}
function createPermissionServiceBusiness()
{

    $roles = ["Manager", "Customer Services", "Operations", "Technician"];

    foreach ($roles as $key => $role) {
        $role = Role::create([
            'name' => $role . "SVP_B_" . auth()->user()->id,
            'group_type' => 'System Default',
            'type' => 'BUSINESS',
            'vender_id' => auth()->user()->id
        ]);

        $permissions = Permission::where('group_type', 'BUSINESS')->get()->pluck('id');

        $role->syncPermissions($permissions);
    }

    return 1;
}


function existsInArray($entry, $array)
{
    foreach ($array as $compare) {
        if ($compare == $entry) {
            return true;
        }
    }
    return false;
}
function accountVerfied()
{
    $count = 0;

    $user = auth()->user();
    $count += collect($user['accounts'])->where('type', '!=', 'App')->where('user_verified', '!=', 'Verified')->count();
    $count +=  VenderAddress::orderBy('is_change', 'desc')->where('vender_id', $user['id'])->where('status', '!=', 'Verified')->count();
    $count += BankAccount::where('vender_id', $user['id'])->where('status', '!=', 'Verified')->count();
    if ($user['profile']['vat_info'] != 'Verified') {
        $count += 1;
    }
    if ($user['profile']['business_info'] != 'Verified') {
        $count += 1;
    }
    if ($user['user_verified'] != 'Verified') {
        $count += 1;
    }

    return $count;
}
function accountAdminVerfied($user_id)
{
    $count = 0;

    $user = User::find($user_id);
    $count += collect($user['accounts'])->where('type', '!=', 'App')->where('user_verified', '!=', 'Verified')->count();
    $count +=  VenderAddress::orderBy('is_change', 'desc')->where('vender_id', $user['id'])->where('status', '!=', 'Verified')->count();
    $count += BankAccount::where('vender_id', $user['id'])->where('status', '!=', 'Verified')->count();
    if ($user['profile']['vat_info'] != 'Verified') {
        $count += 1;
    }
    if ($user['profile']['business_info'] != 'Verified') {
        $count += 1;
    }
    if ($user['user_verified'] != 'Verified') {
        $count += 1;
    }

    return $count;
}
