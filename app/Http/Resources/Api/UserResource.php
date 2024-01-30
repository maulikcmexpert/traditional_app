<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DocumentType;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ($this->id && $this->user_id) {
            $educationDetail = [];
            if ($this->user_education != null) {
                foreach ($this->user_education as $value) {
                    $data = [
                        'user_id' => $value->user_id ? $value->user_id : null,
                        'school_name' => $value->school_name ? $value->school_name : null,
                        'year' => $value->year ? $value->year : null,
                        'qualification' => $value->qualification ? $value->qualification : null,
                        'degree' => $value->degree ? $value->degree : null,
                    ];
                    $educationDetail[] = $data;
                }
            }
            $ducument_type = DocumentType::where(
                'id',
                $this->document_type_id
            )->get();

            // dd($ducument_type[0]->name);
            return [
                'user_detail_id' => $this->id ? $this->id : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'gender' => $this->gender ? $this->gender : null,
                'birth_date' => $this->birth_date ? $this->birth_date : null,
                'document_type_id' => $this->document_type_id ? $this->document_type_id : null,
                'document_type' => $ducument_type[0]->name ? $ducument_type[0]->name : null,
                'document' => $this->document ? $this->document : null,
                'document_number' => $this->document_number ? $this->document_number : null,
                'latitude' => $this->latitude ? $this->latitude : null,
                'longitude' => $this->longitude ? $this->longitude : null,
                'institute_name' => $this->institute_name ? $this->institute_name : null,
                'about' => $this->about ? $this->about : null,
                'portfolio' => $this->portfolio ? $this->portfolio : null,
                'work_experience' => $this->work_experience ? $this->work_experience : null,
                'achievement' => $this->achievement ? $this->achievement : null,
                'skill' => $this->skill ? $this->skill : null,
                'hobby' => $this->hobby ? $this->hobby : $this->hobby,
                'facebook_link' => $this->facebook_link ? $this->facebook_link : null,
                'instagram_link' => $this->instagram_link ? $this->instagram_link : null,
                'linkedin_link' => $this->linkedin_link ? $this->linkedin_link : null,
                'other_link' => $this->other_link ? $this->other_link : null,
                'image' => $this->image ? $this->image : null,
                'user_education' => ($educationDetail) ? $educationDetail : null,
            ];
        } else {
            return [
                'user_id' => $this->id,
                'name' => $this->name,
                'mobile' => $this->detail,
                'country_code' => $this->country_code,
                'role' => $this->role,
                'email' => $this->email,
                'accessToken' => $this->accessToken,
            ];
        }
    }
}