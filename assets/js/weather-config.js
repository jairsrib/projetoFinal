// Configuração do sistema de previsão do tempo
const WEATHER_CONFIG = {
  // Sua chave da API OpenWeatherMap
  API_KEY: 'b202074e6f0ff18fbf8a8b97726dfbae',
  
  // Cidade padrão (pode ser alterada)
  DEFAULT_CITY: 'São Paulo',
  
  // Intervalo de atualização em minutos
  UPDATE_INTERVAL: 5,
  
  // Unidades de temperatura (metric = Celsius, imperial = Fahrenheit)
  UNITS: 'metric',
  
  // Idioma das descrições
  LANGUAGE: 'pt_br'
};

// Função para obter a localização do usuário (opcional)
function getUserLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        // Aqui você pode usar as coordenadas para obter o clima da localização atual
        console.log('Localização obtida:', lat, lon);
      },
      function(error) {
        console.log('Erro ao obter localização:', error);
      }
    );
  }
}

// Função para alterar a cidade
function setCity(cityName) {
  WEATHER_CONFIG.DEFAULT_CITY = cityName;
  // Recarregar dados do clima
  if (typeof initWeather === 'function') {
    initWeather();
  }
}

// Função para alterar a API key
function setApiKey(apiKey) {
  WEATHER_CONFIG.API_KEY = apiKey;
  // Recarregar dados do clima
  if (typeof initWeather === 'function') {
    initWeather();
  }
} 