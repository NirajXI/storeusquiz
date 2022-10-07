<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">View Questions</div>

                    <div class="card-body">
                        <table class="table table-bordered" v-if="!loading">
                            <thead>
                                <tr>
                                    <th scope="col">Question</th>
                                    <th scope="col">Time (Seconds)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="question in questions">
                                    <td>{{question.question}}</td>
                                    <td>{{question.time}}</td>
                                    <td>
                                        <span v-if="question.is_active" class="text-success">
                                            Active
                                        </span>
                                        <span v-if="!question.is_active" class="text-danger">
                                            Inctive
                                        </span>
                                    </td>
                                    <td>
                                        <span class="btn btn-danger" v-if="question.is_active"  v-on:click="statusQuestion(question,false)">
                                            Delete
                                        </span>
                                        <span class="btn btn-success" v-if="!question.is_active" v-on:click="statusQuestion(question,true)">
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
            questions:[],
            loading:true,
        }
    },
    mounted() {
        this.getQuestions();
    },
    methods: {
        getQuestions () {
            this.loading = true;
            axios.get("/api/question").then((response) => {
                this.questions = response.data.questions;
                this.loading = false;
            })
            .catch((error) => {
           
            });
        },

        statusQuestion(question,status){
            axios.patch('/api/question/'+question.question_id, {
                'question': question.title,
                'time':question.time,
                'is_active':status
            }).then(function (response) {
                if(response.data.message === 'success'){
                    question.is_active = status;
                }
            }).catch(error => {

            });
        },
    },
}
</script>