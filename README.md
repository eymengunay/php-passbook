# PHP PASSBOOK LIBRARY

## Introduction

I have created this handy library just out of curiosity while experimenting with the new [Passbook](http://www.apple.com/ios/whats-new/#passbook "Passbook") and even though it can create any kind off pass it still misses [PassKit Web Service](https://developer.apple.com/library/ios/#documentation/PassKit/Reference/PassKit_WebService/WebService.html#//apple_ref/doc/uid/TP40011988 "PassKit Web Service") support. You can start creating your own passes by passing few configurable items and images. Requires P12 & WWDR certificates and a Pass Type ID. See requesting certificates section for more information. 

## Requesting Certificates

### P12 Certificate & Pass Type ID
1. Logon to [iOS Provisioning portal](https://developer.apple.com/ios/manage/passtypeids/index.action "iOS Provisioning portal") and click on Pass Type IDs
2. Follow the instructions to create a Pass Type ID
3. Once you have created, click on configure and download the .cer file
4. Add downloaded file to your Keychain Access simply by clicking
5. Locate the certificate in Keychain Access and select Export pass in right click menu
6. Enter a password and save the P12 certifacate somewhere that the library can reach

Note down also your Pass Type ID. You will find it above download button in the following format:

ABC123ABC1.pass.com.your-company.id

The part starting with pass.com is your teamIdentifier and first 10 characters are passTypeIdentifier

### WWDR Certificate