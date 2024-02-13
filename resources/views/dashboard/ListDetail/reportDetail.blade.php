<div class="modal fade" id="detail-{{$report['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="detail-person">
                    <h5> {{ $report['user_name'] }} </h5>
                    <p>{{ $report['user_class'] }}</p>
                    <p>{{ $report['type'] }}</p>
                    <p>{{ $report['user_room'] }}</p>
                    <br>
                    <p><b>Deskripsi kerusakan:</b><p>
                    <p>{{ $report['description'] }}</p>
                    <br>
                    <p>Status : {{$report['viewStatus']}}</h6>
                </div>

                @if ($report['viewStatus'] == 'On Progress')

                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $report['uploadPhoto'])}}" alt="photo">

                    </div>
                @elseif ($report['viewStatus'] == 'Selesai')
                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $report['photoAdmin'])}}" alt="photo">

                    </div>

                @else

                    <div class='no-photo-uploaded'>
                        <p>No photo uploaded</p>
                    </div>

                @endif


                {{-- @if ($theatre['is_late'] == 0)

                @else
                    <div class='no-photo-uploaded'>
                        <p>No photo uploaded</p>
                    </div>

                @endif --}}

        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>
