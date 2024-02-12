<div class="modal fade" id="selesai-{{$report['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5> --}}
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5>Do you want to finish this report?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="/dashboard/report" method="post">
                <button type="button" class="btn btn-primary">Done</button>
          </form>
        </div>
      </div>
    </div>
  </div>
