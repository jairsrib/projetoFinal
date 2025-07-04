// Usar configuração do arquivo de config
const API_KEY = WEATHER_CONFIG.API_KEY;
const CITY = WEATHER_CONFIG.DEFAULT_CITY;

// Mapeamento de códigos de clima para ícones
const weatherIcons = {
  // Céu limpo
  '01d': '☀️', // dia
  '01n': '🌙', // noite
  
  // Poucas nuvens
  '02d': '⛅', // dia
  '02n': '☁️', // noite
  
  // Nuvens dispersas
  '03d': '☁️',
  '03n': '☁️',
  
  // Nuvens quebradas
  '04d': '☁️',
  '04n': '☁️',
  
  // Chuva
  '09d': '🌧️',
  '09n': '🌧️',
  
  // Chuva com trovões
  '10d': '🌦️',
  '10n': '🌧️',
  
  // Trovões
  '11d': '⛈️',
  '11n': '⛈️',
  
  // Neve
  '13d': '❄️',
  '13n': '❄️',
  
  // Neblina
  '50d': '🌫️',
  '50n': '🌫️'
};

// Mapeamento de códigos para descrições em português
const weatherDescriptions = {
  '01d': 'Céu limpo',
  '01n': 'Céu limpo',
  '02d': 'Poucas nuvens',
  '02n': 'Poucas nuvens',
  '03d': 'Nuvens dispersas',
  '03n': 'Nuvens dispersas',
  '04d': 'Nuvens quebradas',
  '04n': 'Nuvens quebradas',
  '09d': 'Chuva leve',
  '09n': 'Chuva leve',
  '10d': 'Chuva',
  '10n': 'Chuva',
  '11d': 'Trovões',
  '11n': 'Trovões',
  '13d': 'Neve',
  '13n': 'Neve',
  '50d': 'Neblina',
  '50n': 'Neblina'
};

// Função para obter dados do clima
async function getWeatherData() {
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?q=${CITY}&appid=${API_KEY}&units=${WEATHER_CONFIG.UNITS}&lang=${WEATHER_CONFIG.LANGUAGE}`
    );
    
    if (!response.ok) {
      throw new Error('Erro ao buscar dados do clima');
    }
    
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Erro ao obter dados do clima:', error);
    return null;
  }
}

// Função para atualizar a interface com os dados do clima
function updateWeatherUI(weatherData) {
  if (!weatherData) {
    // Em caso de erro, mostrar dados padrão
    document.querySelector('.card-time-cloud-day').textContent = 'Erro';
    document.querySelector('.card-time-cloud-temp').textContent = '--°C';
    document.querySelector('.card-time-cloud-desc').textContent = 'Sem dados';
    document.getElementById('weather-icon').innerHTML = '❓';
    return;
  }

  const temp = Math.round(weatherData.main.temp);
  const weatherCode = weatherData.weather[0].icon;
  const description = weatherData.weather[0].description;
  
  // Atualizar temperatura
  document.querySelector('.card-time-cloud-temp').textContent = `${temp}°C`;
  
  // Atualizar descrição
  document.querySelector('.card-time-cloud-desc').textContent = description;
  
  // Atualizar ícone
  const iconElement = document.getElementById('weather-icon');
  const icon = weatherIcons[weatherCode] || '❓';
  iconElement.innerHTML = icon;
  
  // Aplicar classes CSS baseadas no clima
  const cardElement = document.querySelector('.card-time-cloud');
  cardElement.className = 'card-time-cloud'; // Reset classes
  
  // Adicionar classes específicas baseadas no clima
  if (weatherCode.startsWith('01')) {
    cardElement.classList.add('weather-clear');
  } else if (weatherCode.startsWith('02') || weatherCode.startsWith('03') || weatherCode.startsWith('04')) {
    cardElement.classList.add('weather-cloudy');
  } else if (weatherCode.startsWith('09') || weatherCode.startsWith('10')) {
    cardElement.classList.add('weather-rainy');
  } else if (weatherCode.startsWith('11')) {
    cardElement.classList.add('weather-stormy');
  } else if (weatherCode.startsWith('13')) {
    cardElement.classList.add('weather-snowy');
  } else if (weatherCode.startsWith('50')) {
    cardElement.classList.add('weather-foggy');
  }
}

// Função para atualizar data e hora
function updateDateTime() {
  const now = new Date();
  
  const diasSemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
  
  const diaElement = document.querySelector('.card-time-cloud-day');
  const dataElement = document.querySelector('.card-time-cloud-day-number');
  const horaElement = document.querySelector('.card-time-cloud-hour');
  
  if (diaElement && dataElement && horaElement) {
    diaElement.textContent = diasSemana[now.getDay()];
    
    const dia = now.getDate().toString().padStart(2, '0');
    const mes = (now.getMonth() + 1).toString().padStart(2, '0');
    const ano = now.getFullYear();
    dataElement.textContent = `${dia}/${mes}/${ano}`;
    
    const hora = now.getHours().toString().padStart(2, '0');
    const minuto = now.getMinutes().toString().padStart(2, '0');
    horaElement.textContent = `${hora}:${minuto}`;
  }
}

// Função principal para inicializar o sistema de clima
async function initWeather() {
  // Atualizar data e hora imediatamente
  updateDateTime();
  
  // Buscar dados do clima
  const weatherData = await getWeatherData();
  updateWeatherUI(weatherData);
  
  // Atualizar baseado na configuração
  setInterval(async () => {
    const newWeatherData = await getWeatherData();
    updateWeatherUI(newWeatherData);
  }, WEATHER_CONFIG.UPDATE_INTERVAL * 60 * 1000);
  
  // Atualizar data e hora a cada minuto
  setInterval(updateDateTime, 60000);
}

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', initWeather);

// Função para permitir mudança de cidade (opcional)
function changeCity(newCity) {
  CITY = newCity;
  initWeather();
} 