<div class="modal fade" id="detail-{{$machine['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="detail-person">
                    <h5> {{ $machine['user_name'] }} </h5>
                    <p>{{ $machine['user_class'] }}</p>
                    <p>{{ $machine['machine_name'] }}</p>
                    <p>{{ $machine['date'] }}</p>
                    <p>{{ $machine['desc'] }}</p>
                    <p>Status : {{$machine['viewStatus']}}</h6>
                </div>

                @if ($machine['is_late'] == 0)
                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $machine['uploadPhoto'])}}" alt="photo">

                    </div>
                @else
                    <div class='no-photo-uploaded'>
                        <p>No photo uploaded</p>
                    </div>

                @endif

        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>
