<template>
  <div>
    <button class="login-btn" @click="goToLoginPage">Se connecter</button>

    <h1>Liste des Héros</h1>

    <button @click="handleCreateHero">
      {{ showForm ? "Annuler" : "Créer un Héros" }}
    </button>

    <div v-if="showForm">
      <h2>Créer un Nouveau Héros</h2>
      <form @submit.prevent="createHero">
        <div>
          <label>Nom :</label>
          <input type="text" v-model="newHero.Name" required />
        </div>
        <div>
          <label>Sexe :</label>
          <select v-model="newHero.Sex" required>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Inconnu">Inconnu</option>
          </select>
        </div>
        <div>
          <label>Planète d'Origine :</label>
          <input type="text" v-model="newHero.OriginPlanet" required />
        </div>
        <div>
          <label>Description (min 20 caractères) :</label>
          <textarea v-model="newHero.Description" required minlength="20"></textarea>
        </div>

        <div>
          <label>Pouvoirs :</label>
          <input type="text" v-model="newHero.Powers" />
        </div>
        <div>
          <label>Ville :</label>
          <input type="text" v-model="newHero.Town" />
        </div>
        <div>
          <label>Gadgets :</label>
          <input type="text" v-model="newHero.Gadgets" />
        </div>
        <div>
          <label>Équipe :</label>
          <input type="text" v-model="newHero.Team" />
        </div>
        <div>
          <label>Véhicule :</label>
          <input type="text" v-model="newHero.Vehicule" />
        </div>

        <button type="submit">Créer</button>
      </form>
    </div>

    <ul v-if="!showForm">
      <li v-for="hero in heroes" :key="hero.HeroId">
        <router-link :to="`/hero/${hero.HeroId}`">{{ hero.Name }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "HomePage",
  data() {
    return {
      heroes: [],
      showForm: false,
      newHero: {
        Name: "",
        Sex: "Inconnu", 
        OriginPlanet: "",
        Description: "",
        Powers: "",
        Town: "",
        Gadgets: "",
        Team: "",
        Vehicule: "",
      }
    };
  },
  mounted() {
    this.fetchHeroes();
  },
  methods: {
    async fetchHeroes() {
      try {
        const response = await axios.get('http://localhost/api/heroes');
        this.heroes = response.data;
      } catch (error) {
        console.error("Erreur Axios :", error);
      }
    },
    handleCreateHero() {
      const token = localStorage.getItem('UserId');
      console.log("Token trouvé:", token); 
      if (!token) {
        alert("Vous devez être connecté pour créer un héros !");
        this.$router.push('/');
      } else {        
        this.showForm = !this.showForm;
      }
    },
    async createHero() {      
      if (!this.newHero.Name || !this.newHero.Sex || !this.newHero.OriginPlanet
       || !this.newHero.Description || this.newHero.Description.length < 20) {
        alert("Veuillez remplir tous les champs obligatoires.");
        return;
      }      
      const heroData = { ...this.newHero };
      if (!heroData.Powers) heroData.Powers = null;
      if (!heroData.Town) heroData.Town = null;
      if (!heroData.Gadgets) heroData.Gadgets = null;
      if (!heroData.Team) heroData.Team = null;
      if (!heroData.Vehicule) heroData.Vehicule = null;
      heroData.UserId = localStorage.getItem("UserId");
      console.log("Données envoyées au serveur:", heroData); 
      try {  
        const response = await axios.post('http://localhost/api/heroes/create', heroData, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        });
        console.log("Héros créé :", response.data);
        this.heroes.push(response.data);
        this.newHero = {
          Name: "",
          Sex: "Inconnu",
          OriginPlanet: "",
          Description: "",
          Powers: "",
          Town: "",
          Gadgets: "",
          Team: "",
          Vehicule: "",
        };
        this.showForm = false;
        this.$router.push("/home");
      } catch (error) {
        console.error("Erreur lors de la création du héros :", error);
      }
    },
    goToLoginPage() {
      this.$router.push('/');
    }
  }
};
</script>

<style>
@import '@/assets/home.css';
</style>
