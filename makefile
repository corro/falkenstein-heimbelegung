all:
	zip -r com_heimbelegung.zip com_heimbelegung/* -x com_heimbelegung/.hg

install:
	sudo -u http cp -r com_heimbelegung/site/* /srv/http/components/com_heimbelegung/
	sudo -u http cp -r com_heimbelegung/admin/* /srv/http/administrator/components/com_heimbelegung/

uninstall:
	rm -R /srv/http/components/com_heimbelegung
