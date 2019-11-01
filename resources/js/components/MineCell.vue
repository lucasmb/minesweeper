<template>
    <div class="mine-cell cell" @click.prevent="check(celldata)" @click.right.prevent="toggleFlag(celldata)">
        <div v-if="celldata.revealed && celldata.mineTotals">
            {{ celldata.mineTotals }}
        </div>
        <div v-if="celldata.revealed && celldata.isBomb"> B0 </div>

        <div v-if="celldata.flagged"> F </div>
        <div v-if="celldata.revealed && celldata.mineTotals == 0">0</div>

    </div>
</template>

<script>
    export default {
        name: "MineCell.vue",
        props: {
            cell: {
                type: Object,
                required: true,
            },
            gameover: {required: true}
        },
        data() {
            return {
                celldata: this.cell,
            }
        },
        methods: {
            check(cell) {
                if (!this.gameover) {
                    axios.post('/api/game/checkcell', {
                        x: this.celldata.x,
                        y: this.celldata.y,
                    })
                        .then(response => {
                            //  let cellb = this.board[x][y];
                            if (response.status == 200) {

                                if (response.data.autoreveal) {
                                    alert(response.data.autoreveal);
                                    this.$emit('multiReveal', response.data.autoreveal);

                                    return;
                                }
                                console.log('cell');
                                console.log(cell);
                                console.log(response);
                                this.celldata = response.data.celldata;
                                cell = response.data;
                            }
                            if (response.status == 201) {
                                alert('Game OVer');
                                this.$emit('gameOver');
                            }

                            // this.board[x][y] = response.data;
                        }).catch(error => {
                        console.log(error)
                    });
                }
            },
            toggleFlag(cell) {
                axios.post('/api/game/toggleflag', {
                    x: this.celldata.x,
                    y: this.celldata.y,
                })
                    .then(response => {
                        if (response.status == 200) {
                            this.celldata = response.data;
                            //cell = response.data;
                        }
                    }).catch(error => {
                    console.log(error)
                });
            },
        },
    }
</script>

<style scoped>

</style>
