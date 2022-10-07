<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">View Quizzez</div>

                    <div class="card-body">
                        <table class="table table-bordered" v-if="!loading">
                            <thead>
                                <tr>
                                    <th scope="col">Quiz Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="quiz in quizzez">
                                    <td>{{quiz.title}}</td>
                                    <td>
                                        <span v-if="quiz.is_active" class="text-success">
                                            Active
                                        </span>
                                        <span v-if="!quiz.is_active" class="text-danger">
                                            Inctive
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-danger" v-if="quiz.is_active"  v-on:click="statusQuiz(quiz,false)">
                                            Delete
                                        </span>
                                        <span class="btn btn-success" v-if="!quiz.is_active" v-on:click="statusQuiz(quiz,true)">
                                            Active
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
            quizzes:[],
            loading:true,
        }
    },
    mounted() {
        this.getQuizzes();
    },
    methods: {
        getQuizzes () {
            this.loading = true;
            axios.get("/api/quiz").then((response) => {
                this.quizzez = response.data.quizzez;
                this.loading = false;
            })
            .catch((error) => {
           
            });
        },

        statusQuiz(quiz,status){
            const vm = this;
            axios.patch('/api/quiz/'+quiz.quiz_id, {
                'title': quiz.title,
                'is_active':status
            }).then(function (response) {
                if(response.data.message === 'success'){
                    vm.getQuizzes();
                }
            }).catch(error => {

            });
        },
    },
}
</script>