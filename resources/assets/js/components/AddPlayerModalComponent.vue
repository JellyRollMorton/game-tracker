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
                  <div class="alert alert-danger" v-if="errors.length > 0">
                      <strong>Error:</strong>
                      <li v-for="error in errors">
                          {{ error }}
                      </li>
                  </div>
                  <form>
                      <div class="form-group">
                          <label for="add-player-modal-name">Player Name</label>
                          <input type="text" class="form-control" id="add-player-modal-name">
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" v-on:click.native="addPlayerButtonClick" class="btn btn-primary">Add Player</button>
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
        data: function() {
            return {
                errors: []
            }
        },
        methods: {
            addPlayerButtonClick: function(event) {
                var name = $('#add-player-modal-name').val();

                var addPlayerModalComponent = this;
                $.post("/api/players", {
                        name: name
                    })
                    .done(function(data) {
                        $('#add-player-modal').modal('hide');
                        $('#add-player-modal-name').val('');
                        addPlayerModalComponent.$bus.emit('player-added', {});
                        addPlayerModalComponent.errors = [];
                    }).fail(function(data) {
                        var errors = []

                        for (var k in data.responseJSON.errors) {
                            errors.push(data.responseJSON.errors[k][0]);
                        }

                        addPlayerModalComponent.errors = errors;
                    });
            }
        }
    }
</script>