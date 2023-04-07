# QNB Finansbank VPOS Test Project

This is just a test project to experience QNB Finansbank VPOS features and TXN types.

## To install and use on your locale

Before starting you might need to install valet tool to run project on your locale with a SSL Certificate.
To do so, please [refer its docs](https://laravel.com/docs/9.x/valet#installation).


Clone the repository and cd in:
```
git clone https://github.com/farouttravel/qnb-vpos
cd qnb-vpos
```

Link as valet web app and secure:
```shell
valet link qnb-vpos
valet secure qnb-vpos
valet isolate php@8.1
```

Create a `.env` file from blueprint:
```shell
cp .env.example .env
```
Then please edit your `.env` file and set the necessary credentials. 
Now if everything went well and, your app is up and running, you can visit [https://qnb-vpos.test](https://qnb-vpos.test)
and start testing.

## Disclaimer
This script is only for testing and exploring the API of the services provided by the bank, only use it for
this purpose, never insert any production credentials and use it at your own risk.
