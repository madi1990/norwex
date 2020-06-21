<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Customer;
use App\Http\Models\CustomerStatus;
use App\Http\Models\Order;

class populateData extends Command
{
    use LogableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populateData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to populate data for the Customer, Status and Order tables';

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
     * @return mixed
     */
    public function handle()
    {
        $customerStatusCode = [
            'AC' => 'Active',
            'RE' => 'Removed'
        ];
        $orderStatus = ['Pending', 'Delivering', 'Cancelled', 'Completed'];
        // Truncate all the rows
        Customer::truncate();
        CustomerStatus::truncate();
        Order::truncate();
        $this->echoLog('Truncating all tables');
        foreach($customerStatusCode as $code => $name){
            $customerStatus = new CustomerStatus();
            $customerStatus->Code = $code;
            $customerStatus->Name = $name;
            $customerStatus->save();
        }
        $this->echoLog('Populated CustomerStatus table');
        for($i = 1;$i <= 20;$i++){
            $customer = new Customer();
            $customer->Name = 'test'. str_pad($i, 3, '0', STR_PAD_LEFT);
            $random = rand(1, 5000);
            if($random <= 4500) $customerStatus = 'AC';
            else $customerStatus = 'RE';
            $customerStatusModel = CustomerStatus::where('Code', $customerStatus)->first();
            $customer->CustomerStatusId = $customerStatusModel->CustomerStatusId;
            $customer->save();
        }
        $this->echoLog('Populated Customer table');
        for($j = 1;$j <= 200;$j++){
            $customerId = rand(1, 18);
            $status = $orderStatus[array_rand($orderStatus)];
            $order = new Order();
            $order->CustomerId = $customerId;
            $order->OrderStatus = $status;
            $order->OrderTotal = mt_rand(1 * 100, 50 * 100) / 100;
            $order->save();
        }
        $this->echoLog('All done');
    }
}
