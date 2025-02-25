<template>
  <div class="hero-page">
    <router-link :to="'/home'" class="back-link">Page d'accueil</router-link>
    
    <div v-if="isModifiable" class="action-links">
      <a @click="togglePage">Modifier le héros</a>
      <a @click="deleteHero">Supprimer le héros</a>
    </div>

    <div v-if="!updateHero" class="hero-detail">
      <h2>{{ hero.Name }}</h2>
      <h4>Sexe : {{ hero.Sex }}</h4>
      <p>Planète d'origine : {{ hero.OriginPlanet }}</p>
      <p>{{ hero.Description }}</p>

      <div class="section">
        <h5>Pouvoirs :</h5>
        <ul>
          <li>{{ hero.Powers }}</li>
        </ul>
      </div>

      <div class="section">
        <h5>Gadgets :</h5>
        <ul>
          <li>{{ hero.Gadgets }}</li>
        </ul>
      </div>

      <div class="section">
        <p>Protège la ville de : {{ hero.Town }}</p>
        <p>Équipe : {{ hero.Team }}</p>
        <p>Véhicule : {{ hero.Vehicule }}</p>
        <p>Fiche faite par : {{ hero.UserName }}</p>
      </div>
    </div>

    
    <div v-if="updateHero" class="update-form">
      <form @submit.prevent="updateHeroData">
        <div v-for="(value, key) in updatedHero" :key="key" class="form-group">
          <template v-if="!['HeroId', 'UserId', 'created_at', 'updated_at', 'UserName'].includes(key)">
            <label>{{ capitalize(key) }} :</label>
            <input v-if="key !== 'Description'" type="text" v-model="updatedHero[key]" />
            <textarea v-if="key === 'Description'" v-model="updatedHero[key]" required minlength="20"></textarea>
          </template>
        </div>
        <button type="submit" class="submit-btn">Mettre à jour</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['HeroId'],
  data() {
    return {
      hero: {},
      updatedHero: {},
      isModifiable: false,
      updateHero: false,
    };
  },
  mounted() {
    this.getHeroData();
  },
  methods: {
    async getHeroData() {
      try {
        const response = await axios.get(`http://localhost/api/heroes/${this.HeroId}`);
        this.hero = this.completeData(response.data);
        this.updatedHero = { ...this.hero };
        this.isModifiable = this.hero.UserId === localStorage.getItem('UserId');
      } catch (error) {
        console.error('Erreur lors de la récupération des données du héros:', error);
      }
    },
    togglePage() {
      this.updateHero = !this.updateHero;
    },
    async updateHeroData() {
      try {
        const cleanedData = this.cleanData(this.updatedHero);
        await axios.put('http://localhost/api/heroes/update', cleanedData, {
          headers: { 'Content-Type': 'application/json' },
        });
        this.getHeroData(); 
        this.togglePage(); 
      } catch (error) {
        console.error('Erreur lors de la mise à jour du héros:', error);
      }
    },
    async deleteHero() {
      const confirmation = window.confirm('Êtes-vous sûr de vouloir supprimer ce héros ?');
      if (confirmation) {
        try {
          await axios.delete(`http://localhost/api/heroes/delete/${this.HeroId}`, {
            headers: { 'Content-Type': 'application/json' },
          });
          this.$router.push('/home');
        } catch (error) {
          console.error('Erreur lors de la suppression du héros:', error);
        }
      }
    },
    cleanData(hero) {
      for (let key in hero) {
        if (!hero[key] || hero[key] === 'Aucune info') {
          hero[key] = null;
        }
      }
      return hero;
    },
    completeData(hero) {
      for (let key in hero) {
        if (hero[key] === null) {
          hero[key] = 'Aucune info';
        }
      }
      return hero;
    },
    capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }
  },
};
</script>

<style>
@import "@/assets/details.css";
</style>
