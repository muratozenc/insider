<template>
    <div class="container">
        <h2 class="text-center">Tournament Teams Selection</h2>

        <div class="row">
            <div class="col-md-12 small">
                <form>
                    <div class="form-group mb-2">
                        <label>1st Team</label>
                        <select v-model="selected.first" class="form-control" required>
                            <option v-for="team in teams" :value="team.id" v-if="!(team.id == selected.second || team.id == selected.third || team.id == selected.fourth)">{{team.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>2nd Team</label>
                        <select v-model="selected.second" class="form-control" required>
                            <option v-for="team in teams" :value="team.id" v-if="!(team.id == selected.first || team.id == selected.third || team.id == selected.fourth)">{{team.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>3rd Team</label>
                        <select v-model="selected.third" class="form-control" required>
                            <option v-for="team in teams" :value="team.id" v-if="!(team.id == selected.first || team.id == selected.second || team.id == selected.fourth)">{{team.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>4th Team</label>
                        <select v-model="selected.fourth" class="form-control" required>
                            <option v-for="team in teams" :value="team.id" v-if="!(team.id == selected.first || team.id == selected.second || team.id == selected.third)">{{team.name}}</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" @click="createFixture()"> Create Fixture with Selected Teams </button>
                </form>
            </div>
        </div>
    </div>
   
</template>

<script>
    export default {
        data() {
            return {
                team: {},
                teams: {},
                selected: {}
            }
        },
        created() {
            this.getTeams();
        },
        methods: {
            createFixture() {
                this.axios.post('http://127.0.0.1:8000/api/fixtures', this.selected)
                    .then(response => {
                        this.$router.push({ name: 'GeneratedFixtures' })
                    })
                    .catch(error=>{
                      console.log(error)
                    })
            },
            getTeams() {
              this.axios.get('http://127.0.0.1:8000/api/teams').then(response => {
                this.teams = response.data;
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>