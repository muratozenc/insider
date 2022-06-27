<template>
    <div class="container">
        <h2 class="text-center">Create Team</h2>
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'TeamIndex' }" class="btn btn-primary btn-sm float-right mb-2">Back</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 small">
                <form>
                    <div class="form-group mb-2">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="team.name" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Nationality</label>
                        <select v-model="team.nationality_id" class="form-control">
                            <option v-for="nation in nations" :value="nation.id">{{nation.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>GK Ability</label>
                        <input type="number" class="form-control" v-model="team.gk_ability">
                    </div>
                    <div class="form-group mb-2">
                        <label>Defense Ability</label>
                        <input type="number" class="form-control" v-model="team.defence_ability">
                    </div>
                    <div class="form-group mb-2">
                        <label>Midfield Ability</label>
                        <input type="number" class="form-control" v-model="team.midfield_ability">
                    </div>
                    <div class="form-group mb-2">
                        <label>Forward Ability</label>
                        <input type="number" class="form-control" v-model="team.forward_ability">
                    </div>
                    <div class="form-group mb-2">
                        <label>Supporter Strenght *</label>
                        <input type="number" class="form-control" v-model="team.supporter_strenght">
                    </div>
                    <div class="form-group mb-2">
                        <label>Home Power **</label>
                        <input type="number" class="form-control" v-model="team.home_power">
                    </div>
                    
                    <button type="button" class="btn btn-primary" @click="createTeam()">Create</button>
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
                nations: {}
            }
        },
        mounted() {
            this.getNation();
        },
        methods: {
            createTeam() {
                this.axios.post('http://127.0.0.1:8000/api/teams', this.team)
                    .then(response => {
                        this.$router.push({ name: 'TeamIndex' })
                    })
                    .catch(error=>{
                      console.log(error)
                    })
            },
            getNation() {
                this.axios.get(`http://127.0.0.1:8000/api/nations`)
                   .then((response) => {
                       this.nations = response.data;
                   });
            }
        }
    }
</script>