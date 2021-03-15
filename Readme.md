# PHP & HTML 응용 1편

[TOC]

## 1. HTML을 PHP로

html을 기반으로 뮤지션을 소개하는 페이지를 만들었다. 그러나 페이지가 늘어남에 따라 모든 페이지를 하나 하나 html로 수작업 하는 것은 비효율적이다. 그래서 php 시스템을 도입하기로 결정했다.

아래의 코드는 index.html 기존의 뮤지션 소개 페이지이다.

```html
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>위대한 뮤지션</title>
  </head>
  <body>
    <h1><a href="index.html">The greatest Musician</a></h1>
    <ol>
      <li><a href="1.html">Michael Jackson</a></li>
      <li><a href="2.html">Kurt Cobain</a></li>
      <li><a href="3.html">Jeff Buckley</a></li>
    </ol>
    <h2>위대한 뮤지션 세 명을 소개한다.</h2>
    <p>
      <img src="./img/Michael jackson1.jpg" width="100%">
    </p>
    <p>
      <img src="./img/3Kurt.jpg" width="100%">
    </p>
    <p>
      <img src="./img/2Jeff.jpg" width="100%">
    </p>
  </body>
</html>

```

우리는 여기에 새로운 기능을 도입하여  

```html
<li><a href="1.html">Michael Jackson</a></li>
<li><a href="2.html">Kurt Cobain</a></li>
<li><a href="3.html">Jeff Buckley</a></li>
```

이 부분을 새롭게 탈바꿈 할 것이다. 바로 url을 이용할 것이다.

### 1.2. URL 파라미터

일단 기본적으로 url을 이용하여 정보(쿼리)를 전송할 수 있다. 이 말은 즉 저기 링크 자체가 url이기 때문에 저 링크마다 다른 값의 url을 가질 수 있다. 

아니 애초에 저 세개가 다르고만 다른 값을 가진다는 게 뭐가 대수여?

라고 생각할 수 있지만 우리는 url을 통하여 id 값을 보낼 수 있다. 즉 한 페이지에서 여러개의 id값을 받아 출력할 수 있다는 소리이다. 우선 간단하게 php는 사용하지 않은 상태에서 예제를 만들겠다.

```html
<ol>
      <li><a href="index.php?id=1">Michael Jackson</a></li>
      <li><a href="index.php?id=2">Kurt Cobain</a></li>
      <li><a href="index.php?id=3">Jeff Buckley</a></li>
    </ol>
```

자, 이 코드는 각 링크마다 1, 2, 그리고 3의 아이디 값을 갖는다. 물론 아직 아무 것도 바뀌지는 않지만 우리는 url이 해당 링크를 클릭할 때 마다 url이 바뀌는 것을 확인 할 수 있다. 여기에 우리는 제목을 저 위에 있는 id 값을 받아 출력을 해 볼 것이다.

이제 비로서 php 코드가 등장한다.

```php+HTML
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>위대한 뮤지션</title>
  </head>
  <body>
    <h1><a href="index.html">The greatest Musician</a></h1>
    <ol>
      <li><a href="index.php?id=1">Michael Jackson</a></li>
      <li><a href="index.php?id=2">Kurt Cobain</a></li>
      <li><a href="index.php?id=3">Jeff Buckley</a></li>
    </ol>
    <h2>
      <?php
        echo $_GET['id'];
        ?>
      </h2>
   
  </body>
</html>
```

저 간단한 $_GET[''] 문법을 통해서 우리는 id갑이 1인 링크를 클링하면 제목으로 1을 출력할 수 있다. 

아직 갈 길이 멀고 지루하다. 조금 건너 뛰어야겠다.

## 2. PHP 반복문과 배열

PHP문법 반복문과 배열을 공부했다. if 문도 공부했다. 그럼 써먹어야한다.

일단 공부를 하다보니 익숙함과 불편함을 느낀다. 익숙함이라 하면 어느 부분인가? 바로 저 링크가 걸려있는 세 개의 코드이다. 저게 한 5개 까지는 그냥 손으로 복붙하면서 만들겠다. 

바로 저 복붙을 하려는 순간 머리를 써야한다. 어차피 공통된 부분이 있다. 

index.php?id= 까지는 똑같지 않은가? 그럼 여기에 저 id값에 따라서 자동으로 그 id에 해당하는 데이터를 출력하는 게 가능하지 않을까?

그래서 data디렉토리를 따로 만들어 제목과 내용만 단순출력 할 수 있도록 구축하고 그 데이터 내용만 index.php에서 출력하도록 만들것이다.

### 2.1. 데이터 스캔

```php+HTML
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>위대한 뮤지션</title>
  </head>
  <body>
    <h1><a href="index.php">The greatest Musician</a></h1>
    <ol>
      <?php
       $list = scandir('./data');
```

첫 번째로 data디렉토리를 운용할 것이기 때문에 이 디렉토리의 배열을 반환하는 함수 scandir() 함수를 사용했다. 그리고 이 값을 $list 변수에 담았다.

### 2.2. while 문 응용, List 만들기

```php+HTML
<?php
       $list = scandir('./data');
       $i = 0;
       while ($i < count($list)) { 
         if ($list[$i] !='.') {
           if ($list[$i] !='..') {
             echo "<li><a href=\"index.php?id=$list[$i]\">$list[$i]</a></li>";
           }
         }
         $i = $i + 1;
       }
       ?>
```

while문에 들어있는 count는 배열의 크기를 확인해주는 함수란다.

그리고 그 안에 if문이 있는데 배열의 처음 시작은 1이 아니라 . 와 .. 다음에 1이다. 그래서 그 부분을 스킵하기 위한 과정이다. 애초에 $i 값을 2로 해도 됐었던 기억이 있지만 i값은 0으로 초기화를 해야하기(아직 왜 굳이 0으로 초기화 해야되는지 모르겠다.) 때문에 그냥 저렇게 했다.

이렇게 해서 리스트를 만들었다.

## 3. If문 함수

if문을 이용하여 나머지 작업을 처리 할 것이다. 우선 id값을 받아 제목을 출력하고 그 다음에 본문도 출력 할 것이다. 그리고 아무런 id값이 없으면 index.php 화면, 즉, 메인 화면이 출력되도록 할 것이다.

### 3.1 isset

```php+HTML
<h2>
      <?php
      if (isset($_GET['id'])) {
        echo $_GET['id'];
      } else {
        echo "위대한 뮤지션 세 명을 소개한다.";
      }
       ?>
    </h2>
```

일단 h2 태그로 감싸고 있다는 걸 인지한다. 그리고 그 안에 isset 함수가 실행된다. id값을 받아서 그 값이 참인이 거짓인지 판별하여 처리하는 역할을 한다. 즉, id값이 있는지 없는지를 확인해주는 함수이다. 그래서 else로 반환하는 코드도 짜놔서 id값이 없으면 메인 페이지 문구처럼 표현할 수 있다. 

### 3.2 file_get_contents

```php+HTML
<?php
      if (isset($_GET['id'])) {
        echo file_get_contents("data/".$_GET['id']);
      } else {
        echo "당신의 최고는 누구인가?";
      }
       ?>
       <br>
       <?php
```

이 본문 부분도 똑같다. 다만 file_get 함수를 이용하여 위에서 만든 data 디렉토리에 있는 데이터 값을 가져오는 역할 하여 본문을 출력한다. 값이 없으면 제목부분과 똑같이 메인페이지처럼 출력되게 해놨다. 



## 4. 완성

```php+HTML
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>위대한 뮤지션</title>
  </head>
  <body>
    <h1><a href="index.php">The greatest Musician</a></h1>
    <ol>
      <?php
       $list = scandir('./data');
       $i = 0;
       while ($i < count($list)) { //저기 괄호 i가 아니라 a로 해놔서 무한루프 걸렸음
         if ($list[$i] !='.') {
           if ($list[$i] !='..') {
             echo "<li><a href=\"index.php?id=$list[$i]\">$list[$i]</a></li>";
           }
         }
         $i = $i + 1;
       }
       ?>
    <h2>
      <?php
      if (isset($_GET['id'])) {
        echo $_GET['id'];
      } else {
        echo "위대한 뮤지션 세 명을 소개한다.";
      }
       ?>
    </h2>
      <?php
      if (isset($_GET['id'])) {
        echo file_get_contents("data/".$_GET['id']);
      } else {
        echo "당신의 최고는 누구인가?";
      }
       ?>
  </body>
</html>
```

이렇게 메인 페이지 하나와 3개의 데이터를 추가하여 뮤지션 소개 페이지를 업그레이드 했다. 여기에 데이터만, 제목과 본문만 추가하면 이 메인페이지에 즉각적으로 열람할 수 있다. 

#### 웹 페이지 모습

![initial](https://github.com/gdmoon144/TheMusicians-ver2.0/blob/main/%ED%8F%AC%ED%8F%B42.jpg?raw=true)
