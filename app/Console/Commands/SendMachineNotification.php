<?php

namespace App\Console\Commands;

use App\Events\NewNotification;
use App\Models\Notification;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SendMachineNotification extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'send:notification';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'this command search in table notifications and send via websockets';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		try {
			$now = date('Y-m-d H:i:s');
			$notifications = Notification::where('date_send_notification', '<=', $now)->where('is_send', 0)->get();
			$notifications->map(function ($notification) {
				$count = $notification->machine->working_sheets()->where('is_open', true)->count();
//				Storage::append("machine.txt", $count);
				if ($count == 0) {
					Notification::where('is_send', false)->where('machine_id', $notification->machine->id)->delete();
				}else{
					event(new NewNotification($notification->message));
					$notification->update(['is_send' => true]);
				}
			});
		} catch (Exception $e) {
			Storage::append("SendMachineNotificationLog.txt", $e);
		} finally {
			return 0;
		}
	}
}
