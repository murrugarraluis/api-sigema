<?php

namespace App\Console\Commands;

use App\Events\NewNotification;
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
		event(new NewNotification('Hola Mundo'));
		return 0;
	}
}
