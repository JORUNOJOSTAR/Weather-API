# Weather API
This application fetch from [weather api](https://www.weatherapi.com/) and returns weather data base on request query.

## Description

This is a project from [roadmap](https://roadmap.sh/projects/weather-api-wrapper-service).

In this application
- Request query are hashed and use as a key for checking data in redis cache
- If data not found, app will fetch data from weather api and result will be save on cache
- Cache data expiration is set as 12 hours

## Tech Stack && Installation
- [Docker](https://docs.docker.com/engine/install/)
- [WEATHER_API KEY](https://www.weatherapi.com/)

## Usage
Clone this repository and rename .env.example as .env .
Add your api key in WEATHER_API_KEY env variable.
Run docker to start the app.
```
docker compose up -d 
```

## End point of the api
BASE URL : http://localhost/api/v1/weather
|QUERY PARAM | DESCRIPTION |
|----------|----------|
| mode | Choose from current, forecast, history, or future. This is required for every request.|
| city | Name of the city to retrieve weather data. Required for every request. |
| days | Number of days  between 1 to 14. Required for forecast mode. |
| dates | Required for history and forecast mode. For history mode, date msut between today and the same date last year. For future mode,a date msut set between today and 300 days from now.|
