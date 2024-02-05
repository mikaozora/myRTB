<div class="modal fade" id="detail-{{$serbaguna['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Penghuni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="detail-person">
                    <h5> {{ $serbaguna['user_name'] }} </h5>
                    <p>{{ $serbaguna['user_class'] }}</p>
                    <p>{{ $serbaguna['room_name'] }}</p>
                    <p>{{ $serbaguna['date'] }}</p>
                    <p>{{ $serbaguna['desc'] }}</p>
                    <p>Status : {{$serbaguna['viewStatus']}}</h6>
                </div>

                @if ($serbaguna['is_late'] == 0)
                    <div class="photo-uploaded">

                        <img class="photo" src="{{asset('data/' . $serbaguna['uploadPhoto'])}}" alt="photo">

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
