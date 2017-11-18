<template>

<div class="modal fade" id="add-game-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>

        <select class="form-control player1-select">
          <option selected="selected">orange</option>
          <option>white</option>
          <option>purple</option>
        </select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')            

            $(".player1-select").select2({
              tags: true
            });
        }
    }
</script>
