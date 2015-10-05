
```
//在 mobile 的銀行存入 1200 gp
Banker.Deposit( mobile, 1200 );

//給 mobile 訊息，出現在左下角的
mobile.SendMessage( "1200 saved" );

//頭頂的訊息
//using Server.Network;
mobile.PublicOverheadMessage( type, hue, ascii, text);
mobile.PublicOverheadMessage( MessageType.Regular, 41, false, "Testing..." );

//似乎是多國語言訊息
mobile.SendLocalizedMessage( int );

//檢查是否在可視範圍
mobile.CanSee( m );

//取得銀行
BankBox box = m.BankBox;

//嘗試著放進銀行
if ( !box.TryDropItem( m, bankKey, false ) )

//放到背包
m.AddToBackpack( packKey );
```