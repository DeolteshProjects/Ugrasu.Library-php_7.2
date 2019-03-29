<?php
Class irbis64
{
    //Выводить ответы сервера?
    private $debug = false;

    //Локальные переменные для переноса класса
    private $ip = '192.168.6.30', $port = '6666', $sock;
    private $login = '1', $pass = '11';
    private $id = '554289', $seq = 0;

    /*АРМ ы
     *  АДМИНИСТРАТОР – ‘A‘
     *  КАТАЛОГИЗАТОР – ‘C’
     * КОМПЛЕКТАТОР – ‘M’
     * ЧИТАТЕЛЬ – ‘R’
     * КНИГОВЫДАЧА – ‘B’
     */

    // Распространённые форматы

    const ALL_FORMAT       = "&uf('+0')";  // Полные данные по полям
    const BRIEF_FORMAT     = '@brief';     // Краткое библиографическое описание
    const IBIS_FORMAT      = '@ibiskw_h';  // Формат IBIS (старый)
    const INFO_FORMAT      = '@info_w';    // Информационный формат
    const OPTIMIZED_FORMAT = '@';          // Оптимизированный формат

    // Распространённые поиски

    const KEYWORD_PREFIX    = 'K=';  // Ключевые слова
    const AUTHOR_PREFIX     = 'A=';  // Индивидуальный автор, редактор, составитель
    const COLLECTIVE_PREFIX = 'M=';  // Коллектив или мероприятие
    const TITLE_PREFIX      = 'T=';  // Заглавие
    const INVENTORY_PREFIX  = 'IN='; // Инвентарный номер, штрих-код или радиометка
    const INDEX_PREFIX      = 'I=';  // Шифр документа в базе

    public $arm = 'C'; // Каталогизатор
    public $DataBase = 'FOND'; //
    public $Server_Timeout = 30;
    public $server_ver = '';
    public $Error_Code = 0;

    function __construct() {}

    //Разлогирование при уничтожении класса
    function __destruct() { $this->logout(); }

    //Методы замены входных параметров
    function set_server($ip, $port = '6666')
    {
        $this->ip = $ip;
        $this->port = (int)$port;
    }

    function set_user($login, $pass)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    function set_arm($arm)
    {
        $this->arm = $arm;
    }

    function set_db($DataBase)
    {
        $this->DataBase = $DataBase;
    }

    function set_id($id)
    {
        $this->id = $id;
    }

//Коды возврата сервера
    function error($code = '')
    {
        if ($code == '') $code = $this->Error_Code;

        switch ($code) {
            case '0':
                return "<div class='alert alert-success'>Ошибки нет (Нормальное завершение)</div>";
            case '1':
                return "<div class='alert alert-danger'>Ошибка при выполнении операции! </p> Сервер не ответил! Код ошибки: 1;</div>";
            case '-1111':
                return '<div class=\'alert alert-danger\'>Ошибка выполнения сервера</div>';
            case '-2222':
                return '<div class=\'alert alert-danger\'>WRONG PROTOCOL</div>';
            case '-3333':
                return '<div class=\'alert alert-danger\'>Пользователь не существует</div>';
            case '-3334':
                return '<div class=\'alert alert-danger\'>Незарегестрированный пользователь не сделал ibis-reg</div>';
            case '-3335':
                return '<div class=\'alert alert-danger\'>Неверный уникальный идентификатор</div>';
            case '-3336':
                return '<div class=\'alert alert-danger\'>Нет доступа к командам АРМа</div>';
            case '-3337':
                return '<div class=\'alert alert-danger\'>Пользователь уже авторизован в системе</div>';
            case '-4444':
                return '<div class=\'alert alert-danger\'>Пароль не подходит</div>';

            case '-6666':
                return '<div class=\'alert alert-danger\'>Сервер перегружен, достигнуто максимальное число потоков обработки</div>';
            case '-7777':
                return '<div class=\'alert alert-danger\'>Не удалось запустить/прервать поток администратора</div>';

            case '-100':
                return '<div class=\'alert alert-danger\'>-1 - заданный MFN вне пределов БД</div>';
            case '-300':
                return '<div class=\'alert alert-danger\'>Монопольная блокировка БД</div>';
            case '-401':
                return '<div class=\'alert alert-danger\'>Ошибка при открытии trm файлов</div>';
            case '-402':
                return '<div class=\'alert alert-danger\'>Ошибка при записи</div>';
            case '-403':
                return '<div class=\'alert alert-danger\'>Ошибка при актуализации</div>';

            case '-600':
                return '<div class=\'alert alert-danger\'>1-запись логически удалена</div>';
            case '-602':
                return '<div class=\'alert alert-danger\'>запись заблокированна на ввод</div>';
            case '-607':
                return '<div class=\'alert alert-danger\'>ошибка autoin.gbl</div>';

            case '-140':
                return '<div class=\'alert alert-danger\'>MFN за пределами базы</div>';
            case '-5555':
                return '<div class=\'alert alert-danger\'>База не существует</div>';
            case '-400':
                return '<div class=\'alert alert-danger\'>Ошибка при открытии файла mst или xrf</div>';
            case '-603':
                return '<div class=\'alert alert-danger\'>Запись логически удалена</div>';
            case '-601':
                return '<div class=\'alert alert-danger\'>Запись удалена</div>';
            case '-202':
                return '<div class=\'alert alert-danger\'>Термин не существует</div>';
            case '-203':
                return '<div class=\'alert alert-danger\'>TERM_LAST_IN_LIST</div>';
            case '-204':
                return '<div class=\'alert alert-danger\'>TERM_FIRST_IN_LIST</div>';

            case '-608':
                return '<div class=\'alert alert-danger\'>Не совпадает номер версии у сохраняемой записи</div>';
        }
        return '<div class=\'alert alert-danger\'>Неизвестный код возврата: ' . $code . '</div>';
    }

//Собираем строку поискового запроса
    function getQuery($Author = null, $Title = null, $WordKey = null) {
        //Совляем запрос
        $Query = "";
        if (!empty($Author)) {
            $Query = $Query . '("A='.$Author.'$")';
        }
        if (!empty($Title)) {
            if (!empty($Query)) {
                $Query = $Query.' * ("T='.$Title.'$")';
            } else {
                $Query = $Query.'("T='.$Title.'$")';
            }
        }
        if (!empty($WordKey)) {
            if (!empty($Query)) {
                $Query = $Query.' * ("K='.$WordKey.'$")';
            } else {
                $Query = $Query.'("K='.$WordKey.'$")';
            }
        }
        if ($this->debug) echo "<div class='alert alert-info'>Итоговый поисковый запрос: ".$Query."</div>";
        return $Query;
    }

//Подключение к серверу
    function connect()
    {
        if ($this->debug) echo "<div class='alert alert-primary'>";
        if ($this->debug) echo "<div class='alert alert-heading'>Подключение к серверу библиотеки:</div>";
        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->sock === false) {
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при содании сокета!</div></div>";
            return false;
        } else {
            if ($this->debug) echo "<div class='alert alert-success'>Сокет соединения успешно создан!</div>";
        }
        if (@socket_connect($this->sock, $this->ip, $this->port)) {
            if ($this->debug) echo "<div class='alert alert-success'>Соединение с сервером успешно установленно!</div></div>";
            return true;
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при соединении с сервером!</div></div>";
            return false;
        }
    }

//Подтверждение авторизации
    function loginVerification()
    {
        if ($this->debug) echo "<div class='alert alert-info'><div class='alert alert-heading'>Выполняется попытка авторизации</div>";
        if ($this->debug) echo "</div>";
        $Packet = implode("\n", array('N', $this->arm, 'N', $this->id, $this->seq, '','','','',''));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer[10] == 0) {
            if ($this->debug) echo "<div class='alert alert-success'>Подтверждение авторизации прошло успешно!</div>";
            return true;
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Произогла ошибка при подтвержении регистрации.</div>";
            $this->error_code = $Answer[10];
            if ($this->debug) print_r($Answer);
            return false;
        }
    }

// Авторизация
    function login()
    {
        if ($this->debug) echo "<div class='alert alert-light'><div class='alert alert-heading'>Выполняется попытка авторизации</div>";
        //Попытка подключиться к модулю "Катологизатору"
        //$Packet = implode("\n", array('A', $this->arm, 'A', $this->id, $this->seq, $this->login));
        $Packet = implode("\n", array('A', $this->arm, 'A', $this->id, $this->seq, '', '', '', '', '', $this->login, $this->pass));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        //Если подключение не удалось, выводим ошибки
        //if ($Answer === 0) print_r($Answer);
        if (($Answer === false)) {
            $this->Error_Code = 1;
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при попытке авторизации!<p>";
            if ($Answer === false)  if ($this->debug) echo "Ответ от сервера не получен!";
            else  if ($this->debug) echo "Сервер вернул пустой ответ!";
            if ($this->debug) echo "<p></div></div>";
            return false;
        }

        //Если обнаружн код ошибки, выводим его на экран
        if (!empty($Answer[10])) {
            $this->Error_Code = $Answer[10];
        }

        if ($this->Error_Code != 0) return false;
        $this->server_timeout = $Answer[11];
        $this->server_ver = $Answer[4];
        if ($this->debug) echo "<div class='alert alert-success'>Авторизация прошла успешно!</div>";
        if ($this->debug) echo "</div>";
        return true;
    }



// Завершение сессии
    function logout()
    {
        if ($this->debug) echo "<div class='alert alert-primary'><div class='alert alert-heading'>Выход из системы</div>";
        $Packet = implode("\n", array('B', $this->arm, 'B', $this->id, $this->seq, '', '', '', '', '', $this->login));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) {
            if ($this->debug) echo "<div class='alert alert-danger'>Не получен ответ сервера при выходе из системы</div></div>";
            return false;
        }
        if (isset ($Answer[10])) {
            $this->Error_Code = $Answer[10];
            if ($this->Error_Code != 0) {
                if ($this->debug) echo "<div class='alert alert-danger'>Получен код ошибки при выходе из системы</div></div>";
                return false;
            }
        }
        if ($this->debug) echo "<div class='alert alert-success'>Вывод из системы успешно выполнен</div></div>";
        return true;
    }


// Получить максимальный MFN в базе
    function mfnMax()
    {
        $Packet = implode("\n", array('O', 'C', 'O', $this->id, $this->seq, '', '', '', '', '', 'PERIZ'));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        print_r($Packet);
        print_r($Answer);
        if ($Answer == false) return false;
        if (isset($Answer[11])) echo $Answer[11];
        if (!empty($Answer[10])) $this->Error_Code = $Answer[10];
        if ($this->Error_Code > 0) {
            $this->Error_Code = 0;
            return $Answer[10];
        } else {
            return false;
        }
    }

// Получить Версию Сервера Ирбис
    function getServerVersion()
    {
        $Packet = implode("\n", array('1', $this->arm, '1', $this->id, $this->seq, '', '', '', '', ''));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        if ($this->Error_Code > 0) {
            $this->Error_Code = 0;
            return $Answer[10];
        } else {
            return false;
        }
    }

// Чтение словаря
    function termRead($term, $num_terms = '', $format = '')
    {
        // см. инструкцию сервера "7.8	Функции работы со словарем базы данных"
        // если указан формат, по в результат добавляются по одной записи для каждой строки словаря
        $Packet = implode("\n", array('H', $this->arm, 'H', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, $term, $num_terms, $format));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        print_r($Answer);
        $this->Error_Code = $Answer[10];
        if ($this->Error_Code == 0) {
            // массив $terms
            $terms = array();
            $c = count($Answer) - 1;
            for ($i = 11; $i < $c; $i++) {
                $terms[] = $Answer[$i]; // формат ЧИСЛО_ССЫЛОК#ТЕРМИН=ЗНАЧЕНИЕ
            }
            return $terms;
        } else return false;
    }

// Получить список ссылок термина
    function termRecords($term, $num_postings = '', $first_posting = '')
    {
        // $term - список терминов для поиска. формат: "K=фантастика\nK=природа" = вывести список соответствующих хотя бы одному из терминов
        // $num_postings = количество возвращаемых записей из списка, если = 0 то возвращается MAX_POSTINGS_IN_PACKET записей
        // если $first_posting = 0 - возвращается только количество записей, если больше - указывает смещение первой возвращаемой записи из списка
        $first_posting = (int)$first_posting;
        $Packet = implode("\n", array('I', $this->arm, 'I', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, $num_postings, $first_posting, '', $term));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet, true);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        /* основной формат для результатов поиска
                MFN#TAG#OCC#CNT (см. инструкцию к серверу "6.5.3.1	Обыкновенный формат записи IFP")
                    MFN – номер записи;
                    TAG – идентификатор поля назначенный при отборе терминов в словарь;
                    OCC – номер повторения;
                    CNT – номер термина в поле.
        */

        if ($this->Error_Code == 0) {
            $records = array();
            $c = count($Answer) - 1;
            for ($i = 11; $i < $c; $i++) {
                $ret = explode('#', $Answer[$i]);
                // для упрощения возвращаем только список MFN
                // или количество найденных записей (при $first_posting == 0)
                $records = $ret;
            }
            return $records;
        } else return false;
    }

// Получить запись
    function recordRead($mfn, $lock = false)
    {
        /*
            record (
                mfn
                status - состояние записи
                ver - версия записи
                fileds - массив полей записи в формате [номер][повторение] = значение
            )
        */
        $Packet = implode("\n", array('C', $this->arm, 'C', $this->id, $this->seq,  $this->pass, $this->login, '', '', '', $this->DataBase, $mfn, $lock ? 1 : 0, '' ,'', "@" ));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        $mfn_status = explode('#', $Answer[11]);
        $rec_version = explode('#', $Answer[12]);
        $record = array(
            'mfn' => $mfn_status[0],
            'status' => (isset($mfn_status[1]) && $mfn_status[1] != '') ? $mfn_status[1] : 0,
            'ver' => isset($rec_version[1]) ? $rec_version[1] : 0
        );
        if ($this->Error_Code != 0) return false;
        $record['fields'] = array();
        $c = count($Answer) - 1;
        for ($i = 13; $i < $c; $i++) {
            preg_match("/(\d+?)#(.*?)/U", $Answer[$i], $matches);
            $field_num = (int)$matches[1];
            $field_val = $matches[2];
            $record['fields'][$field_num][] = $field_val;
        }
        return $record;
    }

// Поиск записей по запросу
    function recordsSearch($Query, $num_records = 1, $first_record = 0, $format = '@', $min = null, $max = null, $expression = null)
    {
        if ($this->debug) echo "<div class='alert alert-light'><div class='alert alert-heading'>Выполняется попытка поиска записей</div>";
        if ($this->debug) echo "<div class='alert alert-info'>Начался поиск записей по ключу: " . $Query . PHP_EOL ." </div>";
        if ($expression != '')  if ($this->debug) echo "<div class='alert alert-info'>C уточняющими условиями " . $expression . PHP_EOL ." </div>";

        // $search_exp = выражение для прямого поиска
        //		IBIS "I=шифр документа"
        //		IBIS "MHR=место хранения экз-ра"
        //		IBIS "K=ключевые слова"
        //		RDR "A=фио читателя"

        // $num_records = ограничение количества выдаваемых записей
        // 0 - возвращается количество записей не больше MAX_POSTINGS_IN_PACKET

        // $first_record = задает смещение с какой записи возвращать результаты
        // 0 - возвращается только количество найденных записей

        // $format = @ - оптимизированный (см. описание сервера "7.9.1 Поиск записей по заданному поисковому выражению (K)")
        // $format = '@brief' - оптимизированный сокращенный формат (см. BRIEF.PFT - выводится в список записей в окне каталогизатора)

        // $min, $max, $expression - для последовательного поиска. $expression = условие отбора

        //$Packet = implode("\n", array('K', $this->arm, 'K', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, '"'.$Query.'"', $num_records, $first_record, $format, $min, $max, $expression));
        $Packet = implode("\n", array('K',  $this->arm, 'K', $this->id, $this->seq++, $this->pass, $this->login, '', '', '', $this->DataBase, $Query, $num_records, $first_record, $format));

        $Packet = strlen($Packet) . "\n" . $Packet;

        //$Packet = "K C K 558008 3 11 1 FOND \"A=Петров$\" 0 1 0 0";
        $time = microtime();
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) {
            if ($this->debug) echo "<div class='alert alert-danger'>Не получен ответ от сервера выполнении поиска записей</div></div>";
            return false;
        }
        if ($Answer[10] != 0) {
            $this->Error_Code = $Answer[10];
            if ($this->debug) echo "<div class='alert alert-danger'>Получен код ошибки при выполнении поиска</div></div>";
            return false;
        }
        if (!empty($Answer[11])) {
            if (!empty($Answer[11]))  if ($this->debug) echo "<div class='alert alert-success'>Количество найденных записей = " . $Answer[11] . "</div>";
            $ret['number'] = $Answer[11]; // количество найденных записей
        } else {
            if ($this->debug) echo "<div class='alert alert-warning'>По вашему запросу ничего не найденно</div>";
        }

        $c = count($Answer) - 1;
        for ($i = 11; $i < $c; $i++) {
            $ret['records'][] = $Answer[$i];
        }
        if ($this->debug) echo "</div>";
        $time = (microtime() - $time);
        $time = substr($time,0,-3);
        $ret['time'] = $time*10;
        return $ret;
    }


    function sendPacket($Packet)
    {
        if ($this->debug) echo "<div class='alert alert-dark'>";
        if ($this->debug) echo "<div class='alert alert-heading'>Отправка пакета на сервер.</div>";
        if ($this->sock === false) {
            if ($this->debug)  echo "<div class='alert alert-danger'>Произошла ошибка при содании сокета!</div></div>";
            return false;
        } else {
            if ($this->debug) echo "<div class='alert alert-success'>Сокет соединения успешно создан!</div>";
        }
        if ($this->connect()) {
            if ($this->debug)  echo "<div class='alert alert-success'>Соединение к сервером библиотеки для отправки пакета открыто!</div>";
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Ошибка при соединении с сервером во время попытки отправить пакет! </div></div>";
            return false;
        }
        $this->seq++;

        if ($this->debug) echo "<div class='alert alert-info'>Отправленный на сервер пакет: " . $Packet . PHP_EOL . "</div>";
        if (socket_write($this->sock, $Packet, strlen($Packet))) {
            if ($this->debug)  echo "<div class='alert alert-success'>Пакет ---><b>'".$Packet."'</b><--- был отправлен на сервер</div>";
        } else {
            if ($this->debug)  echo "<div class='alert alert-danger'>Отправка пакета на сервер не удалась!</div>";
        }
        $Answer = '';
        if ($this->debug) echo "<div class='alert alert-primary'><div class='alert alert-heading'>Ожидание ответа от сервера</div>";
        /*
         * if ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
            $get_answer = 1;
            echo "<div class='alert alert-success'>Получен ответ от сервера</div></div>";
            while ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
                $Answer .= $buf;
            }
        } else {
            $get_answer = 0;
            echo "<div class='alert alert-danger'>Сервер не ответил на отправленный пакет!</div></div>";
        }/
        */
        while ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
                $Answer .= $buf;

                $get_answer = 1;
        }

        if ($this->debug)  print_r($Answer);

        if ($get_answer == 1) {
            if ($this->debug)  echo "<div class='alert alert-success'>Получен ответ от сервера</div></div>";
        } else {
            if ($this->debug)  echo "<div class='alert alert-danger'>Сервер не ответил на отправленный пакет!</div></div>";
        }

        if ($this->debug) echo "<div class='alert alert-info'>Полученный ответ от сервера: <p>";
        if ($this->debug) print_r($Answer);
        if ($this->debug) echo "</div>";

        socket_close($this->sock);
        if ($this->debug) echo "<div class='alert alert-warning'>Сокет соединения закрыт</div>";
        //echo "<div class='alert alert-primary'>
        //    <p>Ответ сервера на отправленный пакет: </p>
        //    <p>Отправленный пакет: " . $Packet . "</p>
        //    <p>Полученный ответ: " . $Answer . "</p>";
        if ($get_answer) {
            //Если ответ получен, выводим ответ на экран
            //echo "<p class='alert alert-success'>Ответ: " . $Answer . "</p></div></div>";
            if ($this->debug) echo "</div>";
        } else {
            if ($this->debug) echo "<p class='alert alert-danger'>С сервера поступил пустой ответ!</p></div></div>";
        }
        return explode("\r\n", $Answer);
    }

// Раскодировать строку поля на ассоциированный массив с подполями
    function parse_field(&$field)
    {
        $ret = array();
        $matches = explode('^', $field);
        if (count($matches) == 1) {
            $matches = explode("\x1f", $field);
        }
        foreach ($matches as $match) {
            $ret[(string)substr($match, 0, 1)] = substr($match, 1);
        }
        return $ret;
    }

// Раскодировать бинарную строку
    function blob_decode($blob)
    {
        return preg_replace_callback('/%([A-Fa-f0-9]{2})/', function ($matches) {
            return pack('H2', $matches[1]);
        }, $blob);
    }

// Закодировать бинарную строку
    function blob_encode($binary)
    {
        if (strlen($binary) > 100000) return false; // защита от дурака. размер файла не больше 100Кб

        $c = strlen($binary);
        $ret = '';
        // цифры и латинские цифры можно не кодировать в формат %HEX, а выводить напрямую в blob, сокращает на 25% объем данных
        for ($i = 0; $i < $c; $i++) {
            $n = ord(substr($binary, $i, 1));
            if (($n >= 0x30 && $n <= 0x39) || ($n >= 0x41 && $n <= 0x5A) || ($n >= 0x61 && $n <= 0x7A)) {
                $ret .= substr($binary, $i, 1);
            } else {
                $ret .= '%' . ($n < 16 ? '0' : '') . strtoupper(dechex($n));
            }
        }
        return $ret;

    }

    

}// class
?>
