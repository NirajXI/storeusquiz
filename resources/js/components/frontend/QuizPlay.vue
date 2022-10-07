<template>
    <div>
        <div class="wrapper bg-white rounded" v-if="startquiz">
            <div class="content">
                <span class="fa fa-angle-left pr-2"></span>Question Bank
                <p class="text-muted">Multiple Choice Question</p>
                <p class="text-justify h5 pb-2 font-weight-bold">{{currentquestion.question}}</p>
                <div class="options py-3">
                    <label class="rounded p-2 option" v-for="choice in currentquestion.choices">
                        {{choice.choice}}
                        <input type="radio" name="radio" v-on:click="addAnswer(choice)" :disabled="disabled">
                        <span class="crossmark" v-if="!choice.is_right_choice"></span>
                        <span class="checkmark" v-if="choice.is_right_choice"></span>
                    </label>
                </div>
               
            </div>

            <div class="content" v-if="alertmessage">
                <div class="alert alert-success" role="alert">
                    Try Next Question
                </div>
            </div>

            <div class="content" v-if="quizcomplete">
                <div class="alert alert-success" role="alert">
                   You have completed the Quiz Succesfully and you have got {{points}} points
                   return to <a href="/">main page</a> to try other quizzes
                </div>
            </div>

            <input type="submit" value="Next Question" v-if="!quizcomplete" v-on:click="nextQuestion()" class="mx-sm-0 mx-1">
        </div> 
    
        <div class="wrapper bg-white rounded" style="margin-top:10%" v-if="!startquiz">
            <div class="content" v-if="!register">
                <h3>Register For Quiz</h3>
                <hr>
                <div class="form-group mt-5">
                    <input type="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>

                <div class="content" v-if="is_completed">
                    <div class="alert alert-danger" role="alert">
                        This email has already used to finish this quiz try another email
                    </div>
                </div>
                
            </div>

            <div class="content" v-if="register">
                <h3>Begin  Quiz</h3>
                <hr>
                <p>All the best for your quiz</p>
            </div>

            <input type="submit" value="Register" v-if="!register" class="mx-sm-0 mx-1" v-on:click="registerEmail()">
            <input type="submit" value="Start Quiz" v-if="register" class="mx-sm-0 mx-1" v-on:click="startQuiz()">
        </div> 
    
    </div>
</template>

<script>
    export default {
      props: {
        quizId: {
          type: Number,
          default: 0
        },
      },
      data() {
        return {
            email:"",
            quiz_user_id:0,
            points:0,
            startquiz:false,
            register:false,
            questions:[],
            quiz_length:0,
            current_qid:0,
            index:0,
            currentquestion:[],
            correctAnswer:"",
            answered:false,
            alertmessage:false,
            quizcomplete:false,
            disabled:false,
            is_completed:false,
        }
      },
      methods: {
        registerEmail(){
            const vm = this;
            vm.is_completed = false;
            axios.post('/quiz/user/store', {
                'email': this.email,
                'quiz_id': this.quizId,
                'points':0
            }).then(function (response) {
                if(response.data.message === 'success'){
                    vm.quiz_user_id = response.data.quizuser.quiz_user_id;
                    console.log(vm.quiz_user_id,"vm.quiz_user_id");
                    vm.getQuizQuestions();
                    vm.register = true;
                }
                if(response.data.message === 'completed'){
                    vm.is_completed = true;
                }
            }).catch(error => {

            });
        },

        getQuizQuestions () {
            const vm = this;
            vm.loading = true;
            axios.get("/quiz/question/" + this.quizId).then((response) => {
                vm.questions = response.data.questions;
                vm.quiz_length = response.data.questions.length;
                vm.loading = false;
                vm.register = true;
            })
            .catch((error) => {
           
            });
        },

        getCurrentQuestion () {
            const vm = this;
            vm.loading = true;
            axios.get("/quiz/play/question/" + this.current_qid).then((response) => {
                vm.currentquestion = response.data.question;
                vm.loading = false;
            })
            .catch((error) => {
           
            });
        },

        startQuiz(){
            this.startquiz = true;  
            this.index = 0;
            this.current_qid = this.questions[this.index].question_id;
            this.getCurrentQuestion();
        },

        addAnswer(choice){
            this.correctAnswer = choice.is_right_choice;
            this.answered = true;
            this.disabled = "disabled";

            const vm = this;
            axios.post('/quiz/user/answer/store', {
                'quiz_user_id': this.quiz_user_id,
                'question_id': this.current_qid,
                'choice_id': choice.choice_id,
                'is_correct': choice.is_right_choice,
            }).then(function (response) {
                if(response.data.message === 'success'){
                    vm.alertmessage = true;
                }
            }).catch(error => {

            });
        },

        nextQuestion(){
            if(!this.answered){
                alert('answer the current question to move to next');
                return;
            }
            this.currentquestion = [];
            this.disabled = false;
            this.alertmessage = false;
            this.index++;
            if(this.index < this.quiz_length){
                this.current_qid = this.questions[this.index].question_id;
                this.getCurrentQuestion();
            }else{
                this.updateQuiz();
            }
        },

        updateQuiz(){
            const vm = this;
            axios.post('/quiz/user/'+ vm.quiz_user_id, {
            }).then(function (response) {
                if(response.data.message === 'success'){
                    vm.quizcomplete = true;
                    vm.points = response.data.points;
                }
            }).catch(error => {

            });
        },

      }
    }
</script>