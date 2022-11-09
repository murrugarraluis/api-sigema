<?php

namespace App\Console\Commands;

use App\Events\NewNotification;
use App\Models\Notification;
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
		$now = date('Y-m-d H:i:s');
		$notifications = Notification::where('date_send_notification','<=',$now)->where('is_send',0)->get();
		$notifications->map(function ($notification){
			event(new NewNotification($notification->message));
			$notification->update(['is_send'=>true]);
		});
		return 0;
	}
}
