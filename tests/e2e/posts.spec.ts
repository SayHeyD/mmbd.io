import { test } from '@playwright/test';
import common from './common';

test('An unauthenticated user can create a new post', async ({ page }) => {
  await page.goto(`${common.appUrl}/`);
  await page.getByPlaceholder('https://tiktok.com/').click();
  await page.getByPlaceholder('https://tiktok.com/').fill('https://youtube.com/shorts/D4u-BW_YgPA?si=0W4GFPHIxeTNRzAN');
  await page.getByRole('button', { name: 'Get your link!' }).isVisible();
  await page.getByRole('heading', { name: 'Your post is ready! 🎉' }).isVisible();
  await page.getByText('URL Copied!').isVisible();
  await page.goto('https://mmbd.io.test/b07ccd2b4f');
  await page.getByRole('link', { name: 'Create a new post' }).click();
});
