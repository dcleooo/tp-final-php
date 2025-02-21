<template>
  <div class="hero-page">
    <!-- Navigation -->
    <router-link :to="'/home'" class="back-link">Page d'accueil</router-link>
    
    <div v-if="isModifiable" class="action-links">
      <a @click="togglePage">Modifier le héros</a>
      <a @click="deleteHero">Supprimer le héros</a>
    </div>

    <!-- Détails du héros -->
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

    <!-- Formulaire de mise à jour du héros -->
    <div v-if="updateHero" class="update-form">
      <form @submit.prevent="updateHeroData">
        <div v-for="(value, key) in updatedHero" :key="key" class="form-group">
          <!-- Exclusion des champs à ne pas afficher -->
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
        this.getHeroData(); // Recharge les données actualisées du héros
        this.togglePage(); // Cache le formulaire après la mise à jour
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
      // Supprime les champs vides ou inutiles
      for (let key in hero) {
        if (!hero[key] || hero[key] === 'Aucune info') {
          hero[key] = null;
        }
      }
      return hero;
    },
    completeData(hero) {
      // Remplace les valeurs nulles par "Aucune info"
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

<style scoped>
.hero-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.back-link {
  font-size: 1.2em;
  color: #007bff;
  margin-bottom: 20px;
}

.action-links {
  margin-top: 20px;
}

.action-links a {
  color: #007bff;
  margin-right: 20px;
  cursor: pointer;
}

.hero-detail {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.hero-detail h2,
.hero-detail h4 {
  color: #333;
}

.hero-detail .section {
  margin-top: 15px;
}

section ul {
  list-style-type: none;
  padding-left: 0;
}

section ul li {
  margin-left: 20px;
}

.update-form {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  max-height: 80vh; /* Limite la hauteur pour permettre le défilement */
  overflow-y: auto; /* Permet le défilement vertical */
  margin-top: 20px;
}

.update-form .form-group {
  margin-bottom: 15px;
}

.update-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.update-form input,
.update-form textarea {
  width: 100%;
  padding: 10px;
  font-size: 1em;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.update-form button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.1em;
}

.update-form button:hover {
  background-color: #0056b3;
}
</style>
