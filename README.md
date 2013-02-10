# OpenCart_PPCoin
#Original code from John Atkinson (jga) from [BTC Gear](http://btcgear.com/)
### by 

Donations can be paid here: **PDtcFPhMa9Hc9zTfoRG7zcURCRpcpRdMym**

Initial bounty paid by cablepair.

This is an OpenCart payment module that communicates with a PPCoin client using JSON RPC.

This code accurately converts PPC to BTC using the up-to-the-minute Bitparking average (coming soon!!).  It is completely self contained and requires no cron jobs or external hardware other than a properly configured ppcoind server.  Every order creates a new ppcoin address for payment and gives it a label corresponding to the order_id of the order.  It installs like any other OpenCart plugin and it is completely integrated with OpenCart.

This extension has been tested with OpenCart versions between 1.5.2.1 and 1.5.4.1.

Any questions or comments can be sent to FuzzyBear on bitcointalk.org.


# Installation

1. Upload all files maintaining OpenCart folder structure.
2. Install the payment module in the admin console (Extensions > Payments > PPCoin > Install).
3. Edit the payment module settings (Extensions > Payments > PPCoin > Edit).
4. Run at least one test order through checkout up until payment (no payment required).  The first order initializes the PPCoin currency and will return 0 PPC for the order total.

## Explanation of Settings

* *PPCoin RPC Username*: This is the username in the "rpcuser" line of your PPCoin.conf file.
* *PPCoin RPC Host Address*: This is the IP address of the computer PPCoind is running on.
* *PPCoin RPC Password*: This is the password in the "rpcpassword" line of your PPCoin.conf file.
* *PPCoin RPC Port*: This is the port number in the "rpcport" line of your PPCoin.conf file.  The default port is 9902.
* *The prefix for the address labels*: The addresses will be assigned to accounts named with the format [prefix]_[order_id].
* *Show BTC as a store currency*: If you select yes, your customers will be able to view prices in BTC.
* *Status of a new order*: Choose a status for an order that has received payment with 0 confirmations.
* *Status*: Enable the PPCoin payment module here.
* *Sort Order*: Where you want this module to show up in relation to the other payment modules on the checkout page.


* * *

Copyright (c) 2012 John Atkinson (jga)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
