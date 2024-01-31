<div class="modal fade" id="detail-{{$theatre['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Penghuni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="detail-person">
                    <h5> {{ $theatre['user_name'] }} </h5>
                    <p>{{ $theatre['user_class'] }}</p>
                    <p>{{ $theatre['room_name'] }}</p>
                    <p>{{ $theatre['date'] }}</p>
                    <p>{{ $theatre['desc'] }}</p>
                    <p>Status : {{$theatre['viewStatus']}}</h6>
                </div>

                @if ($theatre['is_late'] == 0)
                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $theatre['uploadPhoto'])}}" alt="photo">

                    </div>
                @else
                    <div class='no-photo-uploaded'>
                        <p>Tidak ada foto</p>
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
