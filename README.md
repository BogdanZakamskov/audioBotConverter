<p align="center"><img src="https://sun9-45.userapi.com/c858224/v858224213/10ad81/y2U43kGrk2Q.jpg" width="400"></p>

##Описание продукта

У каждого из нас есть знакомый, который любит отправлять голосовые сообщения. А кто любит слушать голосовухи? Правильно - никто.

Команда GAZEBO представляет проект AudioBotConverter. Это бот для Viber, который позволит Вам конвертировать голосовые сообщения в текст.
Если Вы находитесь на совещании/на лекции/в общественном транспорте просто перешлите сообщение нашему боту и в течение нескольких секунд получите его в текстовом виде.

<p align="center"><img src="https://sun9-64.userapi.com/c857024/v857024324/4086/gs2dSNbIQAk.jpg" width="400"></p>

##Коммерциализация

По статистике на 2019 год более 900 миллионов зарегистрированных пользователей используют Viber регулярно и эта цифра постоянно растет.
<p align="center"><img src="https://sun9-16.userapi.com/c855236/v855236265/188399/MXn7HGKlTdU.jpg"></p>
И при этом у всех этих пользователей до сих пор не было возможности перевода голосовых сообщений в текстовые.
Если посмотреть на успех подобных ботов для мессенджеров ВКонтакте (~143 780 пользователей) и Telegram можно сделать вывод, что проблема
действительно актуальна. Следовательно есть возможность выйти на рынок с новым и востребованным продуктом. 

Монетизация бота будет осуществляться посредством рекламы. В Viber реализована система public аккаунтов, которые можно сравнить с сообществами в контакте.
На общей странице аккаунта можно размещать рекламные посты, а в личной беседе с аккаунтом бота будет осуществляться основной функционал. Таким образом реклама не будет навязчивой и не отпугнет пользователей.

##Стек технологий

<p align="center"><img src="http://pngimg.com/uploads/viber/viber_PNG15.png" width="300">
<img src="https://2019.codefest.ru/upload/partners/logo_1550079373.png" width="300">
<img src="https://sun9-16.userapi.com/c856120/v856120183/17cf82/IxEeWSZBf2I.jpg" width="300"></p>
<p align="center"></p>


Удаленный сервер создали с помошью сервиса YandexCloud. Он позволяет быстро создать и развернуть виртуальную машину с настроенным доступом по ssh.
При первом использовании сервиса YandexCloud предоставляется месяц пробного периода. На это время дается грант в размере 4000 рублей и в пределах этой суммы можно пользоваться всеми услугами сервиса. 
Viber позволяет подключить паблик аккаунты только к серверам, у которых есть ssl сертификат. Соответственно для бота было куплено доменное имя и получен ssl.
YandexSpeechKit позволяет использовать распознование голоса для аудио в формате OggOpus. C помощью утилиты ffmpeg можно закодировать аудио с помощью аудиокодека OPUS и упаковать в контейнер OGG

