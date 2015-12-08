<p align="center">
  <img src="http://imgur.com/NFw6Fwu.png"/>
</p>
<p align="center">
  <i>Do what you want, if you can.</i>
</p>

&nbsp;

# Imperium

帝國是一個基於 PHP 權限管理類別，具有龐大的複雜性，**不應該將帝國用於小型網站（如論壇，購物系統）**

建立一個帝國，精心的規畫是不能少的。帝國針對資源有做特別的處理，

一般來說，權限管理**只管你能否執行什麼動作**，但在帝國之中，

**你可以選擇可否針對「特別物品」執行什麼動作**。

&nbsp;

設想看看：

> 你希望*版主***可以**編輯所有文章，

> 但是**卻不能**編輯*管理員*所發表的文章（或是不能編輯編號 3 的文章，之類）。

> 這個時候，基礎的權限管理系統無法做到這種需求，因為他們**只知道**你「能否編輯文章」，

> 而**不管理文章的編號，或是文章的主人**。

更詳細的將會於稍後提及。

&nbsp;

## 特色

1. 動作請求紀錄

2. 明瞭的使用方法

3. 動作捷徑

4. 角色系統

5. 組織系統

6. 單個使用者可以擁有多個角色

7. 資源針對系統

&nbsp;

## 索引

1. 示範

2. 解釋

  * 我為什麼需要它？
  
  * RBAC、ACL、DAC？
  
  * 帝國包含什麼？

3. 角色

  * 新增
  
  * 選擇
  
  * 指派

4. 組織

  * 新增
  
  * 選擇

5. 權限

  * 基礎於資源上
  
    * 角色
    
    * 組織
    
    * 種類
    
    * 編號

  * 檢查
  
    * 可以嗎？
    
    * 不可以嗎？
  
  * 設置

    * 允許和禁止動作和萬用符號
  
    * 允許和禁止種類

    * 允許和禁止特定編號
    
    * 動作捷徑

  * 取得
  
    * 允許和禁止的資源
    
    * 允許和禁止的權限

6. 「別當個雞掰人」公眾授權條款

## 示範

## 解釋

這裡包含了一些基礎的權限管理解釋，還有你為何會需要它，

然後如果你看完了之後發現你並不需要，請向時間銀行要求索賠吧。

&nbsp;

### 我為什麼需要它？

一個沒有權限管理系統的網站是**很恐怖**的，我的意思是，就算你有分階層*（例如：訪客、使用者、管理員）*

這樣看起來雖然沒什麼，但當你需要人手來管理網站的時候，**你會賦予他們「管理員」的權限**，

好死不死，「管理員」就是網站中**最大的權限**，甚至可以把**整個網站關機**，設想看看，今天一個 22K 的上班族，

**隨時都可以把你的網站關閉**，不覺得很恐怖麼？這就是為什麼**你應該採用權限管理系統**，額外新增一個「版主」來管理網站，

如此一來，他們就**沒辦法**碰到系統深層的功能，當然，你**也可以**不使用權限管理系統來新增「版主」，但是日復一日，

**你可能會有更多的階級**，這個時候，你就沒辦法不使用權限管理系統，除非**你希望每次有新的階級，就更新一次程式碼**。

&nbsp;

### RBAC、ACL、DAC？

管理權限系統分成很多類，連我也不是很明白（沒錯。）

讓我們先談談 **RBAC（Role-Based Access Control）**，下面是你使用 RBAC 會遇見的情況：

```php
if($this->hasRole('管理員') || $this->hasRole('版主') $this->hasRole('使用者'))
{
    ... 程式 ...
}
```

發現了嗎？RBAC 想知道的，**不是你可以做什麼**，而是**你是誰**。

&nbsp;

接下來談談 **ACL （Access Control List）**，說到這裡，ACL 感覺簡單多了。

```php
if($this->can('編輯', '文章'))
{
    ... 程式 ...
}
```

ACL 詢問的是：**你有權力這樣做嗎**？而**不在乎你是誰**（也許還是會在乎一下啦）。

&nbsp;

然後是 **DAC（Discretionary Access Control）**，假設這樣好了，你**不能**編輯 `檔案A` 但是 小明 可以。

那麼你就可以要求 小明 將這個權限新增給你，接著你有了編輯權限後，**你也可以新增給其他人**，讓其他人有權限來編輯這個檔案。

&nbsp;

總而言之：

> RBAC：詢問「你是誰」？

> ACL：詢問「你可以做這件事」嗎？

> DAC：你可以新增給別人相同的權限。

&nbsp;

### 帝國包含什麼？

&nbsp;

## 角色

&nbsp;

## 組織

&nbsp;

## 權限

&nbsp;

## 「別當個雞掰人」公眾授權條款

> 版本一，2009 年 12 月

> 版權所有 (C) 2009 Philip Sturgeon <me@philsturgeon.uk>
 
任何人都有權限複製與發佈本認證的原始或修改過的版本。若要修改本認證，須修改認證名稱。

> 「別當個雞掰人」公眾授權條款
>  複製、散布以及重製的條款和條件

 1. 只要別當個雞掰人，你可以對原作品做任何事情。

     成為雞掰人的定義包括下列 - 但不僅限於：
     
	 1a. 徹底侵權 — 別只是複製這個作品然後改個名字而已。  
	 1b. 販售未經更改的原始碼，這樣**真的**很雞掰。  
	 1c. 修改原始碼並偷偷增加一些有害的內容。這樣會使你成為**真正的**雞掰人。  

 2. 如果你透過修改，或是為此提供相關服務，而或支持原作者而致富，請分享這份愛。只有雞掰人才會只幫自己，而不協助原始作品。
 
 3. 此份原始碼並不具有保固。當你使用他人原始碼發生錯誤，而指責他人時，會讓你看起來**夭壽**雞掰。自己學會修正問題。而一個不雞掰的人應該會送出這個修正給原作者。
