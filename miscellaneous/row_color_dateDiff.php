@php
    function getConditionColor($message){
        $updated_at = $message->updated_at;
        $now = now();
        $diff = $now->diffInDays($updated_at);
        if($diff >= $message->priority->days){
            return 'bg-danger';
        }
        return "";

    }
@endphp

@foreach ($messages as $key =>$message)
    <tr class="{{getConditionColor($message)}}">
        <td class="left">{{ $key+1 }}</td>
        <td class='left'>{{ $message->to_employee->full_name_upper}}</td>
        <td class='left'>{{ $message->from_employee->full_name_upper }}</td>
        <td class='left'>{{ $message->file_sub }}</td>
        <td class='left'>{{ $message->priority->name }}</td>
        <td class='left'>{{ $message->details}}</td>
        <td>
            <form method="post" action="{{route('imo.outboxSend', $message->id )}}">
                @csrf
                <button class="btn btn-success" type='submit'>
                    Send
                </button>
            </form>
        </td>
    </tr>
@endforeach
