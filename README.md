# movie-info
解析第三方影视数据库数据

## 使用

### IMDb

接收唯一参数：imdbId 电影在IMDb的ID
示例

```php
$imdb = new IMDB(1691916);
print_r($imdb->getData());
```

返回的结果示例：

```json
{
    "title": "Before I Fall",
    "year": "2017",
    "country": "USA",
    "runtime": "98min",
    "ratingCount": "9,031",
    "ratingValue": "6.4",
    "language": "English",
    "locations": "British Columbia, Canada",
    "genres": "Drama, Mystery",
    "storyline": "What if you had only one day to change absolutely everything? Samantha Kingston has it all: the perfect friends, the perfect guy, and a seemingly perfect future. Then, everything changes. After one fateful night, Sam wakes up with no future at all. Trapped reliving the same day over and over she begins to question just how perfect her life really was. And as she begins to untangle the mystery of a life suddenly derailed, she must also unwind the secrets of the people closest to her, and discover the power of a single day to make a difference, not just in her own life, but in the lives of those around her - before she runs out of time for good.",
    "directors": "Ry Russo-Young",
    "writers": "Maria Maggenti, Lauren Oliver",
    "poster": "https://images-na.ssl-images-amazon.com/images/M/MV5BNDYwOTY0MDI2OV5BMl5BanBnXkFtZTgwOTE5NzM2MDI@._V1_UX182_CR0,0,182,268_AL_.jpg",
    "boxOffice": "$12,230,791",
    "releaseDate": "3 March 2017 (USA)",
    "rated": "P",
    "actors": "Zoey Deutch, Halston Sage, Logan Miller, Kian Lawley",
    "productions": "Awesomeness TV, Jon Shestack Productions"
}
```
