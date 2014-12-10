# SMS 統一開發架構工作區

隨著大家已經熟悉 Windwalker, composer, ezset 聚合的開發架構，我們需要找一個模式來統一這些套件的安裝與擺放。這個工作區用來討論這些架構並且將實作的程式碼放在此處。

## 目前面臨的問題

### 沒有統一的我們自己的 Composer 位置

Windwalker 與 JConsole 為了製作成 Sandbox 所以不能直接更新，元件內的 composer 又無法跟 plugin 外部共用，我們需要一個針對每個專案的統一 composer（或者 composer 支援 merge 額外 json 檔案又更好了），否則每次我們要裝 3rd library 都要全部 commit，檔案數量太重了。希望有一個接近根目錄的 composer 可以讓我們方便做更新

Joomla 3.4 的 composer.json 已經確定放在根目錄，vendor 確定放在 `libraries/vendor`，我們可以討論一下我們自己的 composer 要怎麼擺放。

### Plugin 與 Listener 的位置無法統一

目前我們依賴於 CMF 的 `dev` plugin 還有 Ezset，大家各自寫有點混亂，而且許多功能如果要寫成外掛又需要刷 schema，有點麻煩。

考慮依照上次的討論結果，將 Ezset 改成巢狀 Listener 的形式。未來會有點像 Bundle 一樣只要塞額外的檔案進去就可以無限擴充 Listener 數量
，不必額外花力氣寫成安裝外掛。

(例如這次的Config抽離工作，其實就很適合寫成套件裝在不同網站上，目前的寫法有些分散)

### 統一驗證身分

已討論過，參見 Trello
https://trello.com/c/lGOX04f2/32-9

### 整合開發工具

目前有 PHPStorm 設定檔、CodeSniffer、less compiler、Gulp、JConsole 各種開發工具，未來還要加入 UnitTest

需要避免開發人員啟動專案的負擔太重。

### 文章更新要刷 Schema 不方便

未來改用 Ezset include 文章

### 其他各類細項

API 文件要怎麼寫？放哪裡？何時 generate 成 HTML? 各種細部問題歡迎補充

## 暫定的解決方案

我希望除了 Windwalker 與 JConsole 以外，還要再加一層是我們自己 SMS 的中間層，因為前兩者是公開套件，不會為了我們自己的流程優化，而 SMS 的中介套件可以根據我們自己的流程製作各種接口，至於如何實作就事我們要討論的了。

## 其他的討論方式

[HackPad](https://uiuxlink.hackpad.com/) 最近挺紅的，但我沒什麼用過，用這討論事情會比較方便嘛？

## Reference

- [Gulp SMS](https://github.com/smstw/gulp-sms)
- [SMS Develop Command Tool](https://github.com/smstw/sms-dev)
- [Development-Tools](https://github.com/smstw/Development-Tools)
- [SMSTW_PHP_CodeSniffer](https://github.com/smstw/SMSTW_PHP_CodeSniffer)
- [sms-coding-standard](https://github.com/smstw/sms-coding-standard)
