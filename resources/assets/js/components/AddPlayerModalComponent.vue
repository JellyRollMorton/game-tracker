<template>

<div class="modal fade" id="add-player-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Player</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form>
          <div class="form-group">
            <label for="add-player-modal-name">Player Name</label>
            <input type="text" class="form-control" id="add-player-modal-name">
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" v-on:click="addPlayerButtonClick" class="btn btn-primary">Add Player</button>
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
        },
        methods: {
            addPlayerButtonClick: function(event) {
                var name = $('#add-player-modal-name').val();

                $.post("/api/players", {
                        name: name
                    })
                    .done(function(data) {
                        $('#add-player-modal').modal('hide');
                    });
            }
        }
    }
</script>