### Step by step commands:
1. copy .env.example and paste as .env
2. composer install
3. npm install 
4. php artisan key:generate
5. ./vendor/bin/sail up -d
6. ./vendor/bin/sail artisan migrate:fresh
7. ./vendor/bin/sail artisan db:seed
8. npm run watch
 ```
Then open in your browser http://localhost


Тестовое задание
Сервис работы с деревом (словарем)


Необходимо реализовать интерфейс (HTML+CSS+JS), бизнес-логику (PHP / Laravel последней версии), базу данных (на выбор) для построения и работы с деревом (словарем) по следующим требованиям.

Цель выполнения: демонстрация имеющихся навыков работы с PHP, JavaScript, CSS, HTML.

Количество элементов в дереве — 500;
Структура дерева (родитель потомок) — в виде случайной организации (RANDOM), при этом количество элементов в одной ветке должно быть от 10 элементов и до случайного (RANDOM).
Значения элементов дерева — слова длиной от 3 символов и более (один элемент — одно слово), сгенерированные на основе текста «Lorem ipsum» в случайном порядке (RANDOM).
Корень дерева — элемент.
Интерфейс в виде интерактивной HTML-страницы, на которой отображается заданное дерево в соответствии с данными требованиями предоставляющая инструменты для работы с деревом.

Система должна эффективно(быстро) работать как на выборку, так и на сохранение/обновление элементов дерева без нарушения структуры. 

Варианты поведения пользователя в интерфейсе в рамках работы с деревом:
Пользователь видит наглядное представление дерева (словаря) элементов, где дочерние элементы отображены вложенными элементами в родительские элементы. Именем элемента — является его значение сгенерированное из «Lorem Ipsum». Глубина вложенных элементов, которые по умолчанию отображаются пользователю — 2 уровня от корневого.
Пользователь может переносить элементы из одних родительских элементов в другие или в корень дерева перетаскиванием мышкой.
Пользователь удаляет элементы (дочерние элементы также удаляются).
Пользователь осуществляет быстрый поиск по дереву с автодополнением, при котором в автодополнении отображаются найденные элементы со своими родителями до корневого элемента в виде дерева. При выборе найденного элемента, отображается часть дерева данного элемента со всеми родителями до корневого элемента и со всеми потомками. Пользователь видит дерево раскрытым до найденного элемента, потомки элемента видит свернутыми.
Пользователь скрывает и раскрывает дочерние элементы любого родительского элемента.


Результат должен быть выложен на GitHub.
