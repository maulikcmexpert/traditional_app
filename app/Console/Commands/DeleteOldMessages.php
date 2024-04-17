<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;
use App\Models\{
    User,
    Setting,
    ApproachRequest
};


class DeleteOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete messages older than 24 hours from Firebase';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $database = Firebase::database();
        $snapshot = $database->getReference('/Overview')->getSnapshot();
        $data = $snapshot->getValue();

        // Convert Firebase snapshot data to array
        $dataArray = json_decode(json_encode($data), true);

        $allUsers = User::select('id')->where('id', '!=', 1)->get()->pluck('id')->toArray();

        foreach ($allUsers as $value) {
            if (isset($dataArray[$value])) {
                $currentTimestamp = Carbon::now();
                foreach ($dataArray[$value] as $val) {


                    $messageTimestamp = Carbon::createFromTimestampMs($val['timeStamp']);
                    $daysDifference = $currentTimestamp->diffInDays($messageTimestamp);
                    $getDay = Setting::select('no_chat_day_duration')->first();
                    if ($getDay != null) {
                        if ($daysDifference > $getDay->no_chat_day_duration) {
                            $data = $database->getReference('/Messages/' . $val['conversationId'])->remove();

                            // leave relation by admin //

                            $leaverealtion = ApproachRequest::where('conversation_id', $val['conversationId'])->first();
                            $data = $database->getReference('/Overview/' . $value . '/' .  $val['conversationId'])->remove();
                            if ($leaverealtion != null) {
                                $leaverealtion->status = 'leave';
                                $leaverealtion->message = 'by admin';
                                $leaverealtion->save();
                                $leaverealtion->delete();
                            }
                        }
                    }
                }
            }
        }
    }
}
