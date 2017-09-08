#!/usr/bin/perl
use Net::LDAPS;

my $us = $ARGV[0];
my $pass = $ARGV[1];
my $serv =$ARGV[2];


my $attrs = ['displayName', 'title', 'physicalDeliveryOfficeName'];
$ldap = Net::LDAPS->new($serv,port => '636') or die "$@";
$log = $ldap->bind ("CN=IMLDCXN1,CN=Users,DC=proteccion,DC=local",password =>"Brazilian10.");
$cons = $ldap->search(filter=>"(samaccountname=$us)", base=>"dc=proteccion,dc=local",attrs => $attrs );


my $attrs = [ 'displayName', 'title','l
'];

my $pruebaq = $ldap->search ( base => "dc=proteccion,dc=local",
                filter => "(samaccountname=*)",
                attrs => $attrs );


my @enq = $pruebaq->entries;

my $er;

foreach $er (@enq) {
	print $er->get_value('');

}




#if ($log->code) {
#          print "Return code: ", $log->code;
#          print "\tMessage: ", $log->error_name;
#}
my $login;
@entries = $cons->entries;
my $final;

foreach $entry (@entries){

$final = $us."|".$entry->get_value('displayName')."|".$entry->get_value('title')."|".$entry->get_value('physicalDeliveryOfficeName')."|".$entry->dn();

$login = $ldap->bind ($entry->dn(),password =>$pass);

if ($login->code) {
#         print "Return code: ", $login->code;
#	 print "\tMessage: ", $login->error_name;
	 print "El usuario y la clave no coinciden";
}else{
	 print $final;
}
}


