<template>
    <div class="container">
        <h2 class="text-center">List of the Teams</h2>
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'TeamCreate' }" class="btn btn-primary btn-sm float-right mb-2">Add Team</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 small">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>GK Ability</th>
                        <th>Defense Ability</th>
                        <th>Midfield Ability</th>
                        <th>Forward Ability</th>
                        <th>Supporter Strenght *</th>
                        <th>Home Power **</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(team, key) of teams">
                            <td>{{ key+1 }}</td>
                            <td>{{ team.name }}</td>
                            <td>{{ team.nationality_name }}</td>
                            <td>{{ team.gk_ability }}</td>
                            <td>{{ team.defence_ability }}</td>
                            <td>{{ team.midfield_ability }}</td>
                            <td>{{ team.forward_ability }}</td>
                            <td>{{ team.supporter_strenght }}</td>
                            <td>{{ team.home_power }}</td>
                            <td>
                                <router-link class="btn btn-success btn-sm" :to="{ name: 'TeamEdit', params: { teamId: team.id }}">Edit</router-link>
                                <button class="btn btn-danger btn-sm" @click="deleteTeam(team.id)">Delete</button>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                teams: {}
            }
        },
        created() {
            this.getTeams();
        },
        methods: {
            getTeams() {
              this.axios.get('http://127.0.0.1:8000/api/teams').then(response => {
                this.teams = response.data;
                }).catch(error=>{
                    console.log(error)
                })
            },
            deleteTeam(teamId) {
                this.$confirm("Do you really want to delete this team?", "Are you sure?", "question").then(()=>{
                    this.axios
                        .delete(`http://127.0.0.1:8000/api/teams/${teamId}`)
                        .then(response => {
                            let i = this.teams.map(data => data.id).indexOf(teamId);
                            this.teams.splice(i, 1)
                        });
                });
            }
        }
    }
</script>