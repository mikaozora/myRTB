<div class="modal fade" id="detail-{{$dapur['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="detail-person">
                    <h5> {{ $dapur['user_name'] }} </h5>
                    <p>{{ $dapur['user_class'] }}</p>
                    <p>{{ $dapur['stuff_name'] }}</p>
                    <p>{{ $dapur['date'] }}</p>
                    <p>{{ $dapur['desc'] }}</p>
                    <p>Status : {{$dapur['viewStatus']}}</h6>
                </div>

                @if ($dapur['is_late'] == 0)
                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $dapur['uploadPhoto'])}}" alt="photo">

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
