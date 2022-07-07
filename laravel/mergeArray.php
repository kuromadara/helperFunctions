array:22 [▼
  "_token" => "684LjG521t7pvNLialCgiTin2Neo6bNtlQV9DcLi"
  "tracking_id" => "1"
  "company" => "BVFCL"
  "ferilizer" => "UREA"
  "dispatch_point" => "NFL Vijaipur-I"
  "proposed_rack_points" => "BARPETA ROAD-RKPT"
  "total_quantity" => "100"
  "request_type" => "1"
  "date_of_dispatch" => "2022-06-06"
  "date_of_arival" => "2022-06-24"
  "district_idBaksa" => array:1 [▼
    0 => "Baksa"
  ]
  "district_id" => array:2 [▼
    0 => "1"
    1 => "2"
  ]
  "district" => array:2 [▼
    0 => "Baksa"
    1 => "Barpeta"
  ]
  "quantityBaksa" => array:1 [▼
    0 => "40"
  ]
  "wholesaler_idBaksa" => array:2 [▼
    0 => "4"
    1 => "4"
  ]
  "quantity_wholesalerBaksa" => array:2 [▼
    0 => "10"
    1 => "10"
  ]
  "district_idBarpeta" => array:1 [▼
    0 => "Barpeta"
  ]
  "quantityBarpeta" => array:1 [▼
    0 => "60"
  ]
  "wholesaler_idBarpeta" => array:2 [▼
    0 => "17"
    1 => "12"
  ]
  "quantity_wholesalerBarpeta" => array:2 [▼
    0 => "10"
    1 => "10"
  ]
  "remarks" => "test"
  "submit" => "send"
]

"data 1: "

array:2 [▼
  0 => array:3 [▼
    "request_rack_id" => "1"
    "district_id" => "Baksa"
    "wholesale_id" => "4"
  ]
  1 => array:3 [▼
    "request_rack_id" => "1"
    "district_id" => "Baksa"
    "wholesale_id" => "4"
  ]
]

"data 2: "

array:2 [▼
  0 => array:1 [▶]
  1 => array:1 [▶]
]

array:4 [▼
  "request_rack_id" => "1"
  "district_id" => "Baksa"
  "wholesale_id" => "4"
  "quantity" => "10"
]

array:4 [▼
  "request_rack_id" => "1"
  "district_id" => "Baksa"
  "wholesale_id" => "4"
  "quantity" => "10"
]

"data 1: "

array:2 [▼
  0 => array:3 [▼
    "request_rack_id" => "1"
    "district_id" => "Barpeta"
    "wholesale_id" => "17"
  ]
  1 => array:3 [▼
    "request_rack_id" => "1"
    "district_id" => "Barpeta"
    "wholesale_id" => "12"
  ]
]

"data 2: "

array:2 [▼
  0 => array:1 [▼
    "quantity" => "10"
  ]
  1 => array:1 [▼
    "quantity" => "10"
  ]
]

array:4 [▼
  "request_rack_id" => "1"
  "district_id" => "Barpeta"
  "wholesale_id" => "17"
  "quantity" => "10"
]

array:4 [▼
  "request_rack_id" => "1"
  "district_id" => "Barpeta"
  "wholesale_id" => "12"
  "quantity" => "10"
]

"district_idBarpeta"

"wholesaler_idBarpeta"

"quantity_wholesalerBarpeta"

"quantity_wholesalerBarpeta"


public function Store(Request $request)
{
    dump($request->all());
    // dump($tracking_id);
    $data = [];

    foreach ($request->district as $key => $value) {
        $district_id = "district_id"."$value";
        $wholesalers_id = "wholesaler_id"."$value";
        $wholeseler_quantity = "quantity_wholesaler"."$value";
        $merge_loop = "quantity_wholesaler"."$value";



        foreach($request->$wholesalers_id as $key => $value){
            $data1[$key] = [
                'request_rack_id' => $request->tracking_id,
                'district_id' => $request->$district_id[0],
                'wholesale_id' => $value,
            ];

        }
        dump("data 1: ",$data1);
        foreach ($request->$wholeseler_quantity as $key => $value) {
            // dump($key);
            $data2[$key] = [

                'quantity' => $value,
            ];


        }
        dump("data 2: ",$data2);
       /*merge block */
        foreach ($request->$merge_loop as $key => $value) {
            $data = array_merge($data1[$key],$data2[$key]);

            // store here
            dump($data);
        }

        // WholesallerTransaction::insert($data);
    }
    dump($district_id);
    dump($wholesalers_id);
    dump($wholeseler_quantity);
    dump($merge_loop);
    // dd($request->all());
}
