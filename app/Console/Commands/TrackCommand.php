<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use function var_dump;

class TrackCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all product stock';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::all();
        $this->output->progressStart($products->count());
       $products->each(function($product) {
           $product->track();
           $this->output->progressAdvance();
       });

       $this->output->progressFinish();
//
//       $this->table(
//           ['First', 'Last'],
//          [ ['Alex', 'Rafuse']]
//       );

//       $this->info('All done!');
    }
}
