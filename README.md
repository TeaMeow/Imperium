<p align="center">
  <img src="http://imgur.com/NFw6Fwu.png"/>
</p>
<p align="center">
  <i>Do what you want, if you can.</i>
</p>

&nbsp;

# Imperium

帝國是一個基於 PHP 的權限管理系統，建立一個帝國需要細心的規劃，

與其他權限管理系統不一樣的地方在於：**帝國是十分重視資源條件的系統。**

如果你不清楚，我們稍候會提到什麼是資源條件。

&nbsp;

# 特色

1. 動作請求紀錄（可選）

2. 明瞭的使用方式

3. 動作捷徑

4. 角色系統

5. 組織系統

6. 單一個使用者可擁有多重角色

7. 資源條件設置

&nbsp;

# 工程清單

1. 動作紀錄系統

2. 取得所有允許、拒絕權限表

3. 若為訪客，則禁止所有 `allow()` 和 `deny()` 的設置

&nbsp;

# 索引

1. [範例](#範例)

2. [設定使用者](#設定使用者)
    
3. [組織](#組織)

    * [建立](#建立)
    
    * [選擇](#選擇)

4. [角色](#角色)

    * [建立](#建立-1)
    
    * [選擇](#選擇-1)

5. [使用者](#使用者)

    * [選擇](#選擇-2)

6. [權限](#權限)

    * [授權和拒絕](#授權和拒絕)
    
        * [授權](#授權)
        
        * [拒絕](#拒絕)
    
        * [萬用符號](#萬用符號)

    * [檢查](#檢查)
    
        * [是否為訪客？](#是否為訪客)
        
        * [可以嗎？](#可以嗎)
        
        * [不可以嗎？](#不可以嗎)
        
        * [同時檢查多個種類](#一次檢查多個種類)
    
    * [基於資源條件](#基於資源條件)
    
        * [針對組織](#針對組織)
        
        * [針對角色](#針對角色)
        
        * [針對種類](#針對種類)
        
        * [針對編號](#針對編號)
        
        * [縮寫](#縮寫)
        
        * [儲存和讀取針對設置](#儲存和讀取針對設置)

7. [動作紀錄](#動作紀錄)

8. [架構](#架構)

9. [和資料庫搭配](#和資料庫搭配)

    * [架構](#架構)
    
        * [組織表](#組織表)
        
        * [角色表](#角色表)
        
        * [使用者角色表](#使用者角色表)
        
        * [角色權限表](#角色權限表)
        
        * [使用者權限表](#使用者權限表)

9. [可參考文件](#可參考文件)

&nbsp;

# 範例

這個範例是帝國大約 80% 的用法，通常能夠滿足*一般人*對權限管理系統的要求，

假設你希望可以特別針對特定使用者、角色、組織持有的資源做判斷，

請在稍候參考任何**有關資源的章節**。

```php
/** 設定現在使用者的編號，假設為 1 */
$imperium->caller(1)
         
         /** 建立一個組織，然後在該組織下新增三個角色 */
         ->addOrg('網站群組')                   // 新增一個組織，名為：網站群組
         ->addRole(['管理員', '版主', '使用者']) // 一次新增三種角色

         /** 新增權限給「網站群組」的「管理員」 */
         ->org('網站群組')        // 選擇「網站群組」這個組織
         ->role('管理員')         // 選擇「管理員」這個角色
         ->allow('編輯', '文章')  // 允許我們選擇的角色「編輯」所有「文章」

         /** 選擇剛才建立的組織，然後讓這個使用者成為管理員 */
         ->org('網站群組')        // 選擇「網站群組」這個組織
         ->assign('管理員');      // 指派使用者成為「網站群組」裡的「管理員」

/** 現在可以像這樣詢問使用者有無權限「編輯」所有「文章」 */
if($imperium->can('編輯', '文章'))
{
    ... 程式 ...
}
         
```

&nbsp;

# 設定使用者

透過 `caller()` 來設定目前使用者的編號，

如果傳入的參數為 `false` 或 `null` 則會返回到訪客狀態（也就是沒有設置 `caller()`）。

```php
/** 將目前使用者指定為編號 1 */
->caller(1)
```

&nbsp;

# 組織

如果你要指配給使用者一個角色，那麼就必須要先有組織，

意思是**你必須先建立組織，才能夠建立角色**。

&nbsp;

## 建立

透過 `addOrg()` 來建立一個新的組織。

```php
/** 新增一個名為「單身俱樂部」的組織 */
->addOrg('單身俱樂部')
```

&nbsp;

## 選擇

當你建立完一個組織後，你未來若要在這個組織下進行任何動作，你就必須先選擇這個組織，

透過 `org()` 來選擇一個組織。

```php
/** 選擇「單身俱樂部」這個組織 */
->org('單身俱樂部')
```

&nbsp;

# 角色

在建立角色之前，必須**要先有至少一個組織**。

&nbsp;

## 建立

在建立之前，你**要先選擇一個組織**，如此一來，才不會讓這個角色沒有歸屬，

透過 `addRole()` 新增一個，或是多個角色。

```php
/** 先選擇名為「亞凡芽愛好會」的組織 */
->org('亞凡芽愛好會')

/** 接著在這個組織下新增「管理員」這個角色 */
->addRole('管理員')

/** 或者，你也可以一次新增多個角色 */
->addRole(['版主', '使用者'])
```

&nbsp;

## 選擇

當你建立完角色後，你可以透過 `role()` 來選擇角色，但是別忘記，**你必須先選擇一個組織**。

```php
/** 先選擇名為「亞凡芽愛好會」的組織 */
->org('亞凡芽愛好會')

/** 然後選擇你要的角色 */
->role('管理員')
```

&nbsp;

# 使用者

使用者在帝國中，其實是不必要的，

但是，有時候你可能不希望以組織，或是角色來授予或拒絕他們權限，

而是希望**這個權限只有這個使用者擁有**，這個時候，你就可以**只選擇使用者自己一個人**。

&nbsp;

## 選擇

透過 `self()` 來只選擇使用者自己，要注意的是，當你使用這個方法，

你先前透過 `org()` 或是 `role()` 所選擇的都會被取消（畢竟你現在只希望選擇使用者自己）。

```php
/** 不需要額外的參數，因為你已經透過先前的 caller() 設置過了 */
->self()
```

&nbsp;

# 權限

當你有了角色、組織，接下來就是時候授權或是不允許他們做什麼了。

假設你希望拒絕「編輯」某個特定組織、角色所持有的「東西」，

請**參考資源條件的章節**。

&nbsp;

## 授權和拒絕

在一般情況下，你沒有授權的，使用者就無法執行，

而**「拒絕」比「授權」還要來的有優先權**，

假設你設置了兩個權限：

> 允許：「編輯」所有「文章」。

> 拒絕：「編輯」「編號 3」的「文章」。

那麼你可以編輯所有文章，**但是**編號 3 的那篇文章則不行。

&nbsp;

### 授權

透過 `allow()` 來允許你所選擇的對象（使用者、角色或組織）做某一件事情。

**請注意：你指定的資源、組織、角色會在使用這個函式後自動清除，因此你之後需要在重新指定一次。**

```php
->allow('編輯', '文章')

/** 或者一次新增多個種類 */
->allow('編輯', ['文章', '相簿', '留言'])
```

&nbsp;

### 拒絕

透過 `deny()` 來拒絕你所選擇的對象（使用者、角色或組織）做某一件事情。

**請注意：你指定的資源、組織、角色會在使用這個函式後自動清除，因此你之後需要在重新指定一次。**

```php
->deny('編輯', '文章')

/** 或者一次拒絕多個種類 */
->deny('編輯', ['文章', '相簿', '留言'])
```

&nbsp;

### 萬用符號

透過 `%` 這個符號，來代表任何事情。

```php
/** 允許對「文章」做出「任何事」 */
->allow('%', '文章')

/** 或是可以「編輯」「任何東西」 */
->allow('編輯', '%')

/** 當然你也可以用在「拒絕」上 */
->deny('移除', '%')
```

&nbsp;

## 檢查

當你設置了權限，你就可以開始透過下列方式，

來確認你的使用者是否有權限執行某一件事情了。

&nbsp;

### 是否為訪客？

透過 `isGuest`（**不是 `isGuest()`**） 來確認是否為訪客，

訪客的定義為：沒有透過 `caller()` 設置成為一個使用者，

倘若你當初用 `caller()` 設置了一個 `false` 或是 `null` 的使用者，**也會被認定為訪客**。

```php
if($imperium->isGuest)
    echo "大哥，你是路人啊！";
```

&nbsp;

### 可以嗎？

透過 `can()` 來詢問是不是**可以**執行某個動作，當然，**你也可以跟萬用符號搭配**。

```php
/** 假設你允許「編輯」「相簿」 */
->allow('編輯', '相簿')

->can('編輯', '相簿')  // True
->can('編輯', '%')    // False


/** 假設你拒絕「編輯」「相簿」 */
->deny('編輯', '相簿')

->can('編輯', '相簿')  // False
->can('編輯', '%')    // False


/** 或是設置一個萬用字元的權限 */
->allow('%', '相簿')

->can('移除', '相簿')  // True
->can('編輯', '相簿')  // True
->can('%', '相簿')    // True
```

&nbsp;

### 不可以嗎？

和 `can()` 相反，透過 `cannot()` 來詢問是不是**不可以**做某一件事情。

```php
/** 假設你允許「新增」「文章」 */
->allow('新增', '文章')

->cannot('新增', '文章')  // False
->cannot('移除', '文章')  // True
->cannot('%',   '文章')  // False


/** 假設你拒絕「新增」「文章」 */
->deny('新增', '文章')

->cannot('新增', '文章')  // True
```

&nbsp;

### 同時檢查多個種類

在 `can()` 和 `cannot()` 之中，

你也可以透過傳入陣列一次檢查多個種類，**但必須全部符合。**

```php
->deny('移除', '相簿')
->deny('移除', '留言')

->cannot('移除', ['文章', '相簿'])  // False
->cannot('移除', ['留言', '相簿'])  // True
```

或者透過 `cannotAny()` 和 `canAny()` 來採用**寬鬆模式**，

意思是只要其中有一個可以（或不可以），則符合條件。

```php
->allow('移除', '相簿')

->canAny('移除', ['文章', '相簿'])  // True
```

&nbsp;

## 基於資源條件

其實在上方我們提到了很多，設想看看，你擁有三個角色：管理員、版主、使用者：

> 管理員：可以刪除**任何人**的文章。

> 版主：可以刪除任何人的文章，但是**不可以刪除管理員的文章**。

> 使用者：只可以刪除**自己**的文章。

現在，透過一般的權限管理系統，**根本沒辦法做到這樣**，

因為他們通常只管理你「是否有權利執行這個動作」而不是「是否有權利**對誰的資源**執行這個動作」

&nbsp;

### 針對組織

假設你希望這個權限對某個組織才生效，透過 `resOrg()` 來針對一個組織。

```php
->resOrg('小安俱樂部')   // 針對「小安俱樂部」這個組織
->allow('刪除', '文章')  // 授權「刪除」「文章」
                        // 請注意：並不是授予給「小安俱樂部」的所有人。


->resOrg('小安俱樂部')                      
->can('刪除', '文章')    // 可以「刪除」「小安俱樂部」內的所有「文章」嗎？
```

發現到了嗎？當你採用 `resOrg()` 的時候，表示**這個權限對什麼組織生效**。

&nbsp;

### 針對角色

透過 `resRole()` 來針對一個角色。

```php
->resRole('管理員')      // 針對「管理員」所持有的資源
->allow('刪除', '文章')  // 授權「刪除」「文章」


->resRole('管理員')                  
->can('刪除', '文章')    // 可以「刪除」「管理員」所發表的「文章」嗎？
```

&nbsp;

### 針對種類

種類就是「文章」、「相簿」這種東西（就是你已經正在用的那個），

事實上你並不需要用到這個功能，倘若你需要的話，透過 `resType()` 來針對一個種類。

```php
/** 這個作法 */
->resType('相簿')
->allow('刪除')

/** 跟這個是一樣的 */
->allow('刪除', '相簿')
```

&nbsp;

### 針對編號

透過 `resId()` 來針對一個編號。

```php
->resId(3)              // 針對任何編號為 3 的資源
->allow('刪除', '文章')  // 授權「刪除」「文章」


->resId(3)                  
->can('刪除', '文章')    // 可以「刪除」任何「編號為 3」 的「文章」嗎？
```
&nbsp;

### 縮寫

如果你覺得一直 `resId()` 過於麻煩，其實你可以在**一些函式最後面直接放上資源編號**：

```php
/** 例如 allow() 或是 deny() */
->allow('刪除', '相簿', 3)
->deny('刪除', '相簿', 3)

/** 或者 can() 跟 cannot() */
->can('刪除', '相簿', 3)
->cannot('刪除', '相簿', 3)
```

&nbsp;

### 儲存和讀取針設置

如果你發現縮寫滿足不了你，你可以直接把你所設置的資源條件**透過 `resSave()` 儲存**，

然後**透過 `resLoad()` 讀取**。

```php
$Data = $imperium->resOrg('伊繁星組織')
                 ->resRole('管理員')
                 ->resType('文章')
                 ->resId(3)
                 ->resSave();  // 儲存！

$imperium->resLoad($Data)      // 讀取！
         ->allow('新增');

$imperium->resLoad($Data)
         ->can('新增')          // True
```

&nbsp;

# 動作紀錄

&nbsp;

# 架構

帝國透過數個陣列儲存這些資料，如果你想要觀看範例架構，

可以開啟 [test/structure.php](test/structure.php)。

&nbsp;

# 和資料庫搭配

你可能會開始好奇，如果帝國沒有任何跟資料庫連接的橋樑，要如何和資料庫搭配使用？

在這裡，我們會提出一些理念，但基於時間，可能沒有辦法實作給你看。

&nbsp;

## 架構

實際上，帝國是非常龐大的，

我們依照大型商業邏輯所規劃出的資料表大約如下，

不過當然，這只是理想，你可以將下列規模縮減。

![資料表](http://imgur.com/xN7mXPC.png)

&nbsp;

### 組織表

這個資料表用來儲存有哪些組織，通常欄位是：

1. 編號－組織的編號。
2. 名稱－組織的名稱。

&nbsp;

### 角色表

這個資料表用來儲存有哪些角色，並且隸屬於哪些組織，通常有這些欄位：

1. 編號－角色的編號。
2. 名稱－角色的名稱。
3. 隸屬組織－這個角色隸屬的組織編號。

&nbsp;

### 使用者角色表

這個資料表用來儲存使用者具有什麼身份，通常會有兩個欄位：

1. 使用者編號－使用者的編號。
2. 角色編號－角色的編號。

&nbsp;

### 角色權限表

這個資料表用來儲存角色擁有和被禁止哪些授權，通常是這些欄位：

1. 權限編號－這個權限的編號，排序用。
2. 角色編號－這個權限是為哪個角色設計的。
3. 資源種類－這個權限針對哪個種類？例如：文章。
4. 資源角色
5. 資源組織
6. 資源編號
7. 已授權－儲存 1 和 0；1 為允許，0 為拒絕。

&nbsp;

### 使用者權限表

與角色權限表十分相同，但這個資料表是基於「使用者」而非「角色」。

1. 權限編號－這個權限的編號，排序用。
2. 使用者編號－這個權限是為哪個使用者設計的。
3. 資源種類－這個權限針對哪個種類？例如：文章。
4. 資源角色
5. 資源組織
6. 資源編號
7. 已授權－儲存 1 和 0；1 為允許，0 為拒絕。

&nbsp;

# 可參考文件

這裡是幾個可能會啟發你創意，或是更能讓你了解這類東西的連結。

[Role Based Access Control in PHP](http://www.sitepoint.com/role-based-access-control-in-php/)

[efficiently/authority-controller](https://github.com/efficiently/authority-controller)

[BeatSwitch/lock](https://github.com/BeatSwitch/lock)

[OWASP/rbac](https://github.com/OWASP/rbac)

[machuga/authority](https://github.com/machuga/authority)