<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\SizeOfOrganization;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\ZodiacSign;
use App\Models\InterestAndHobby;
use App\Models\Lifestyle;
use Illuminate\Http\Request;

class ListController extends BaseController
{

    public function stateList(Request $request)
    {
        $state = State::where('code', $request->country_code)
            ->select('id', 'state as name') // Specify the attributes you want to retrieve
            ->get();
        return $this->sendResponse(__('messages.state_list'), $state);
    }

    public function cityList(Request $request)
    {
        $city = City::where('state_id', $request->state_id)
            ->select('id', 'city as name', 'state_id') // Specify the attributes you want to retrieve
            ->get();
        return $this->sendResponse(__('messages.city_list'), $city);
    }
    public function organizationList(Request $request)
    {
        $organization = User::where('user_type', 'organization')
            ->select('id', 'full_name as name') // Specify the attributes you want to retrieve
            ->get();
        return $this->sendResponse(__('messages.organization_list'), $organization);
    }

    public function zodiacSignList(Request $request)
    {
        $ZodiacSign = ZodiacSign::select('id',  'zodiac_sign as name')->get();
        return $this->sendResponse(__('messages.zodiacsign_list'), $ZodiacSign);
    }
    public function sizeOfOrganizationList(Request $request)
    {
        $ZodiacSign = SizeOfOrganization::select('id',  'size_range as range')->get();
        return $this->sendResponse(__('messages.sizeoforganization_list'), $ZodiacSign);
    }

    public function interestAndHobbyList(Request $request)
    {
        $InterestAndHobby = InterestAndHobby::select('id',  'interest_and_hobby as name')->get();
        return $this->sendResponse(__('messages.interest_hobby_list'), $InterestAndHobby);
    }

    public function lifieStyleList(Request $request)
    {
        $Lifestyle = Lifestyle::select('id',  'life_style as name')->get();
        return $this->sendResponse(__('messages.life_style_list'), $Lifestyle);
    }
}
