FROM nginx:latest

COPY entrypoint.sh /home/entrypoint.sh
RUN tr -d '\015' </home/entrypoint.sh >/home/entrypoints.sh
RUN chmod +x /home/entrypoints.sh
entrypoint "/home/entrypoints.sh"
