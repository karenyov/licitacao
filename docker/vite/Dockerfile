FROM node:18-alpine

WORKDIR /var/www

COPY package.json package-lock.json* ./

RUN npm install

COPY . .

EXPOSE 5174

CMD ["npm", "run", "dev"]
