/**
 * Relation in model
 */

 public function sample()
{
   return $this->belongsTo(TableBModel::class, 'id_a', 'id_b');
}


Table A:

id | id_a  |  abc


Table B:

id | id_b | rate

/**
 * Query
 */

Query = TableAModel::with('sample:id_b,rate')
    ->get();
