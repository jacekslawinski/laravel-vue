FROM mysql:8.0.30
COPY my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 0444 /etc/mysql/conf.d/my.cnf
ADD dump-hardware.sql /docker-entrypoint-initdb.d
