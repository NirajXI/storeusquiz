<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form @submit.prevent="formSubmit">
                    <div class="card">
                        <div class="card-header">Create Quiz</div>

                            <div class="card-body">

                                <div class="form-group mt-3" v-if="form.success">
                                    <div class="alert alert-success" role="alert">
                                        Quiz created successfully
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="title" class="mb-2">Quiz Title:</label>
                                    <input type="text" required class="form-control" id="title" placeholder="Enter Quiz Title" name="title" v-model="title">
                                </div>    
                                
                                <div class="form-group mt-3">
                                    <label for="title" class="mb-2">Select Questions:</label>
                                    <multiselect v-model="value" :close-on-select="false" :clear-on-select="false" :preserve-search="true" :options="questions"  label="question" track-by="question" :multiple="true">
                                    </multiselect>
                                </div>   

                                <div class="form-group mt-3" v-if="!form.validation">
                                    <div class="alert alert-danger" role="alert">
                                        Please select atleast one question
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="alert alert-danger" role="alert" v-for="error in errors">
                                        {{error[0]}}
                                    </div>
                                </div>

                            </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit" v-if="!form.loading">Submit</button>
                            <button class="btn btn-primary" type="submit" v-if="form.loading">Saving.....</button>
                            <button class="btn btn-danger" v-on:click="cancelForm()">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { 
            Multiselect 
        },
        data() {
            return {
                title:"",
                value: null,

                form: {
                    submitted: false,
                    loading:false,
                    validation:true,
                    success:false,
                },

                questions: [],
                errors:[],
            };
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

            async formSubmit() {
                const vm = this;

                if(vm.checkValidation() && !vm.form.loading){                  
                    vm.form.validation = true;
                    vm.form.loading = true;
                    vm.form.success = false;
                    vm.errors = [];

                    axios.post('/api/quiz', {
                        'title': vm.title,
                        'value':vm.value.map(({question_id}) => ({question_id})),
                    }).then(function (response) {
                        if(response.data.message === 'success'){
                            vm.form.success = true;
                            vm.form.loading = false;
                            vm.cancelForm();
                        }else{
                            vm.form.loading = false;
                            vm.errors = response.data.error;
                        }
                    }).catch(error => {

                    });

                }else{                    
                   vm.form.validation = false;
                }
            },

            checkValidation(){
                if(this.value === null){
                    return false;
                }else{
                    return true;
                }
            },

            cancelForm(){
                this.form.loading = false;
                this.title = "";
                this.value = null;
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>