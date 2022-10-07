<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">View Users</div>

                    <div class="card-body">
                        <table class="table table-bordered" v-if="!loading">
                            <thead>
                                <tr>
                                    <th scope="col">Quiz Title</th>
                                    <th scope="col">User Email</th>
                                    <th scope="col">Points</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="userlist in userslist">
                                    <td>{{userlist.title}}</td>
                                    <td>
                                        {{userlist.email}}
                                    </td>
                                    <td>
                                        {{userlist.points}}
                                    </td>
                                    <td>
                                        <span class="btn btn-success" v-if="userlist.is_complete">
                                            Completed
                                        </span>
                                        <span class="btn btn-danger" v-if="!userlist.is_complete">
                                            Incomplete
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div v-if="loading">
                            <h6 class="text-center">Loading....</h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            userslist:[],
            loading:true,
        }
    },
    mounted() {
        this.getUsersList();
    },
    methods: {
        getUsersList () {
            this.loading = true;
            axios.get("/api/quizuser").then((response) => {
                this.userslist = response.data.userslist;
                this.loading = false;
            })
            .catch((error) => {
           
            });
        },

    },
}
</script>