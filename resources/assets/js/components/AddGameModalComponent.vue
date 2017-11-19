<template>
    <div class="modal fade" id="add-game-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Game</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

       <form>
<table id="add-game-player-table">
    <tr>
        <th></th>
        <th class="player-row">Player 1</th>
        <th class="player-row">Player 2</th>
    </tr>
    <tr>
        <td>Name</td>
        <td class="player-row">
            <div class="form-group">
                <select class="form-control" id="player1-select">
                </select>
            </div>
        </td>
        <td class="player-row">
            <div class="form-group">
                <select class="form-control" id="player2-select">
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <td>Score</td>
        <td class="player-row">
            <div class="form-group">
                <input type="text" class="form-control" id="player1-score">
            </div>
        </td>
        <td class="player-row">
            <div class="form-group">
                <input type="text" class="form-control" id="player2-score">
            </div>
        </td>
    </tr>    
</table>
   </form>
             
                       
                   
                 

                </div>
                <div class="modal-footer">
                    <button type="button" v-on:click="addGameButtonClick" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');


            //console.log(bus);

            this.enablePlayerSearchSelect2($("#player1-select"));
            this.enablePlayerSearchSelect2($("#player2-select"));
        },
        methods: {
            enablePlayerSearchSelect2: function(selectElement) {
                selectElement.select2({
                    width: '100%',
                    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                        url: "/api/players/search",
                        dataType: 'json',
                        quietMillis: 250,
                        data: function(term, page) {
                            return {
                                q: term, // search term
                            };
                        },
                        results: function(data, page) { // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to alter the remote JSON data
                            return {
                                results: data.items
                            };
                        },
                        cache: true
                    },
                    theme: "bootstrap"
                });
            },
            addGameButtonClick: function(event) {
                console.log('triggering');

                var players = [{
                    'id': $('#player1-select').val(),
                    'score': $('#player1-score').val()
                }, {
                    'id': $('#player2-select').val(),
                    'score': $('#player2-score').val()
                }, ];

                var addGameModalComponent = this;
                $.post("/api/games", {
                        players: players
                    })
                    .done(function(data) {
                        $('#add-game-modal').modal('hide');
                        $('#player1-select').val('').trigger('change');
                        $('#player1-score').val('');
                        $('#player2-select').val('').trigger('change');
                        $('#player2-score').val('');
                        addGameModalComponent.$bus.emit('game-added', {});
                    });
            }
        }
    }
</script>