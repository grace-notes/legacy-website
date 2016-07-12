FROM xdrum/nginx-extras

RUN apt-get update
RUN apt-get install -y gettext-base

COPY htdocs /usr/share/nginx/html
COPY config.template /etc/nginx/conf.d/config.template

CMD /bin/bash -c "envsubst '$PORT' < /etc/nginx/conf.d/config.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"

