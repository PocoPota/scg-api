# scg API
SuperChat Generatorをサーバーサイドで生成するAPIです.

# What a scg?
scg (SuperChat Generator) はyoutubeのスーパーチャットを擬似的に作成できます。  
Web版はこちら→ [https://scg.pocopota.com/](https://scg.pocopota.com/)

# How to use
`https://api.scg.pocopota.com?name={user name}&icon={icon url}&money={money}&text={comment}`

SAMPLE↓  
![image](https://user-images.githubusercontent.com/71576988/224536305-2b4b0d1f-aaf7-469f-b21e-9ab26cc90705.png)

# Output
画像が返されます.  
画像形式: png  
サイズ: 横335px, 縦可変

# Parameters
|name|description|
|----|----|
|name|表示するユーザー名を指定|
|icon|表示するアイコンURLを指定. png/jpeg/gif/webpに対応|
|money|表示する金額を指定. 半角数字で|
|text|表示するコメントを指定|

# APIs Used
ここで使用したAPIはこちら↓  
https://github.com/PocoPota/apis

# About use
このAPIを使用したLINE/Discord botやその他サービスの開発は大歓迎です！  
サービスを公開した際は是非教えてください！喜びます.

# Note
フォントはNotoSansJPを使用しています. NotoSansJPに含まれない文字は表示されない可能性があります.  
Web版とは表示が若干異なります.  
過剰なアクセスはお控えください.  

# Demo
以下にこのAPIを簡単に試せるデモページを用意しました.  
https://api.scg.pocopota.com/demo

# Services
## scg LINE bot by PocoPota
LINEでスーパーチャットが作れます.  
https://line.me/R/ti/p/@396ccxef

# Others
何か不具合等がありましたらIssueにお願いします. TwitterのDMやDiscordでも構いません.

