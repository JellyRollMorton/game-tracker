<template>
    <div>
        <add-game-modal></add-game-modal>
        <add-player-modal></add-player-modal>
        <div class="toolbar-buttons pull-right">
            <a class="btn btn-primary" v-on:click="addPlayerButtonClick" href="#" role="button">Add Player</a>
            <a class="btn btn-primary" v-on:click="addGameButtonClick" href="#" role="button">Add Game</a>
        </div>
        <table id="player-ranking-table" class="table table-striped table-bordered table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Wins</th>
                    <th>Losses</th>
                </tr>
            </thead>
        </table>
    </div>
</template>

<script>
    export default {
        created() {
            this.$bus.on('game-added', this.refreshPlayerRankings);
            this.$bus.on('player-added', this.refreshPlayerRankings);
        },
        mounted() {
            console.log('Dashboard mounted.');

            var dashboardComponent = this
            $(document).ready(function() {
                dashboardComponent.playerRankingTable = $('#player-ranking-table').DataTable({
                    "ajax": '/api/player_rankings'
                });
            });

        },
        methods: {
            refreshPlayerRankings: function(event) {
                this.playerRankingTable.ajax.reload();
                console.log('refreshing player rankings');
            },
            addGameButtonClick: function(event) {
                $('#add-game-modal').modal();
            },

            addPlayerButtonClick: function(event) {
                $('#add-player-modal').modal();
            }
        }
    }
</script>