<template>
  <div v-if="ConnectionFormVisible">
    <h2>Connexion</h2>
    
    <form @submit.prevent="login">
      <div>
        <label>Email :</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Mot de passe :</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Se connecter</button>
    </form>
    <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
    </div>
    <div v-if="isSignUpFormVisible">
      <h2>Inscription</h2>
      <form @submit.prevent="register">
        <div>
          <label>Nom :</label>
          <input type="text" v-model="name" required />
        </div>
        <div>
          <label>Prénom :</label>
          <input type="text" v-model="firstName" required />
        </div>
        <div>
          <label>Email :</label>
          <input type="email" v-model="emailSignUp" required />
        </div>
        <div>
          <label>Mot de passe :</label>
          <input type="password" v-model="passwordSignUp" required />
        </div>
        <button type="submit">S'inscrire</button>
      </form>
      <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
    </div>
    <p>Pas encore inscrit ? <a @click="toggleForm" v-if="ConnectionFormVisible">Cliquez ici pour vous inscrire</a><a @click="toggleForm" v-if="isSignUpFormVisible">Cliquez ici pour vous connecter</a></p>

    
</template>
<style>
  @import '@/assets/login.css';
</style>
<script>
import axios from 'axios';

export default {
  name: "LoginPage",
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
      ConnectionFormVisible: true,
      
      emailSignUp: "",
      passwordSignUp: "",
      isSignUpFormVisible: false,
      name: "",
      firstName: "",
      
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://localhost/api/users/connection', {
          Email: this.email,
          Password: this.password,
        }, {
          headers : {
            "Content-type" : "application/json"
        }});

        console.log("Connexion réussie :", response.data);

        localStorage.setItem('UserId', response.data.UserId);

        this.$router.push('/home');
      } catch (error) {
        console.error("Erreur de connexion :", error);
        this.errorMessage = error.response?.data?.message || "Erreur inconnue";
      }
    },
    
    toggleForm() {
      this.isSignUpFormVisible = !this.isSignUpFormVisible;
      this.ConnectionFormVisible = !this.ConnectionFormVisible;
    },
    
    async register() {
      try {
        const response = await axios.post('http://localhost/api/users/register', {
          Name: this.name,
          FirstName: this.firstName,
          Email: this.emailSignUp,
          Password: this.passwordSignUp
        }, {
          headers: {
            'Content-Type': 'application/json'
        }});

        console.log("Inscription réussie :", response.data);
        localStorage.setItem('UserId', response.data.UserId);
        this.$router.push('/home');
      } catch (error) {
        console.error("Erreur d'inscription :", error);
        this.errorMessage = error.response?.data?.message || "Erreur inconnue";
      }
    }
  }
};
</script>

