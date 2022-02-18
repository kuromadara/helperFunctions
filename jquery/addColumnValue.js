/*
* Add amounts of selected Rows.
* Check for reference image.
*/
<script>

    function chkBox(enable, workerID, reqID, workerNO, bankID, amount) {
        console.log(enable);
        console.log(workerID);
        console.log(workerNO);

        document.getElementById(workerID).disabled = !enable;
        document.getElementById(workerNO).disabled = !enable;
        document.getElementById(reqID).disabled = !enable;
        document.getElementById(bankID).disabled = !enable;
        document.getElementById(amount).disabled = !enable;

        calculateGrandTotal()
    }

    function calculateGrandTotal() {
        var total = 0;
        // not diabed field jQuery
        $('.amount:enabled').each(function() {
            // check nan
            if(!isNaN(parseFloat($(this).val()))) {
                total += parseFloat($(this).val());
            }
        });
        $('#total').val(total);
    }


</script>

/*
* Blade for table
*/

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="center">#</th>
            <th>Cw NO.</th>
            <th>Name</th>
            <th>Bank Name</th>
            <th>Total Amount</th>

        </tr>
    </thead>
    <tbody>
        @forelse($casual_workers as $key => $casual_worker)
        <tr>
            <td class="center">
                <div class="checkbox-nice">
                    <input type="checkbox" class="checkbox" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][chkBox]"  onclick="chkBox(this.checked, 'workerID_{{$casual_worker->id}}', 'reqID_{{$casual_worker->id}}', 'workerNO_{{$casual_worker->id}}', 'bankID_{{$casual_worker->id}}', 'amount_{{$casual_worker->id}}')"/>
                </div>
            </td>

                <input type="hidden" id="workerID_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][worker_id]" value="{{$casual_worker->casual_worker_id}}" disabled>

                <input type="hidden" id="reqID_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][req_id]" value="{{$casual_worker->requisition_id}}" disabled>
            <td>
                <input type="text" id="workerNO_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][worker_no]" value="{{$casual_worker->casual_worker_no}}" disabled>
            </td>
            <td>
                <input type="text" id="name_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][name]" value="{{$casual_worker->workers->full_name}}" disabled>
            </td>

                <input type="hidden" id="bankID_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][bank_id]" value="{{$casual_worker->workers->bank_id}}" disabled>

            <td>
                <input type="text" id="bankName_{{$casual_worker->id}}" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][bank_name]" value="{{$casual_worker->workers->bank->name}} ({{ $casual_worker->workers->bank->branch_name}})" disabled>
            </td>
            <td>
                <input class="text-right amount" id="amount_{{$casual_worker->id}}" type="number" name="data[{{$casual_worker->workers->bank_id}}][{{$key}}][amount]" value="{{$casual_worker->total_amount}}" disabled>
            </td>
        </tr>


        @empty
        <tr>
            <td style="color:#c13f0e;text-decoration:bold" class="text-center" colspan="14"><b>No data</b></td>
        </tr>
        @endforelse
        <tr>
            <td colspan="5" class="text-right">
                <label for="">Grand Total : </label>
                <input clas="text-right" type="number" id="total" readonly>
            </td>
        </tr>
    </tbody>
</table>
